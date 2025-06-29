<?php

namespace App\Modules\Tender\Domain\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class LotTenderResource extends JsonResource
{

    public function toArray(Request $request): array
    {

        //Делается для того что бы получить актуальное значение number_tender
        $this->refresh();


        return [

            'id' => $this->id,
            'number_tender' => $this->number_tender,
            'general_count_transport' => $this->general_count_transport,
            'price_for_km' => $this->price_for_km,
            'body_volume_for_order' => $this->body_volume_for_order,

            'type_transport_weight' => $this->type_transport_weight,
            'type_load_truck' => $this->type_load_truck,

            'status_tender' => $this->status_tender,
            'type_tender' => $this->type_tender,

            'date_start' => $this->date_start,
            'period' => $this->period,

            'week_period' => WeekPeriodCollection::make($this->week_period),

            'organization_id' => $this->organization_id,
            'agreement_document_tender_link' => $this->createFileLinkDownload($this->agreement_document_tender),
            'array_application_document_tender_link' => $this->createFileLinkDownloadArray($this->application_document_tender),
            'array_specifical_date_period' => SpecificaDatePeriodCollection::make($this->specifical_date_period) ?? null,


        ];
    }

    private function createFileLinkDownload($agreement_document) : ?string
    {

        //что бы тесты прошли надо устанавливать ? и при path ?? ''
        return Storage::disk($agreement_document?->disk)?->exists($agreement_document?->path ?? '')
        ? Storage::disk($agreement_document?->disk)?->url($agreement_document?->path) : null;

    }

    private function createFileLinkDownloadArray($application_document_tender) : array|string|null
    {

        if(collect($application_document_tender)->isNotEmpty()){


            $array = [];

            foreach ($application_document_tender as $object) {
                $array[] = Storage::disk($object->disk)->exists($object->path)
                ? Storage::disk($object->disk)->url($object->path)
                : null ;
            }

            if(count($array) == 1) { return $array[0]; }

            return $array;
        }

        return null;

    }
}
