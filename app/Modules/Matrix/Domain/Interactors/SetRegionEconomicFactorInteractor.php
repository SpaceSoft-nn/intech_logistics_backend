<?php

namespace App\Modules\Matrix\Domain\Interactors;

use DB;
use App\Modules\Matrix\Domain\Models\MatrixDistance;
use App\Modules\Matrix\Domain\Models\RegionEconomicFactor;
use App\Modules\Matrix\App\Data\DTO\CreateRegionEconomicFactorDTO;
use App\Modules\Matrix\App\Data\ValueObject\RegionEconomicFactorVO;
use App\Modules\Matrix\Domain\Actions\CreateRegionEconomicFactorAction;

final class SetRegionEconomicFactorInteractor
{

    public function execute(CreateRegionEconomicFactorDTO $dto) : RegionEconomicFactor
    {
        return $this->run($dto);
    }


    private function run(CreateRegionEconomicFactorDTO $dto) : RegionEconomicFactor
    {
        /** @var RegionEconomicFactor */
        $model = DB::transaction(function () use ($dto) {

            // /** @var ?RegionEconomicFactor */
            // $regionEconomicFactor = $this->findModelRegionEconomicFactor($dto);

            /** @var ?MatrixDistance */
            $matrixDistance = $this->findGarIdInMatrixDistance($dto);

            /** @var RegionEconomicFactor */
            $regionEconomicFactor = $this->createRegionEconomicFactor(
                RegionEconomicFactorVO::make(
                    region_start_gar_id: $matrixDistance->city_start_gar_id ?? null,
                    region_end_gar_id: $matrixDistance->city_end_gar_id ?? null,
                    region_name_start: $dto->region_name_start,
                    region_name_end: $dto->region_name_end,
                    distance: $matrixDistance->distance ?? null,
                    factor: $dto->factor,
                    price: $dto->price,
                    price_form_km: ($matrixDistance) ? $dto->price / $matrixDistance->distance : null,
                    type:  ($dto->type?->value) ? $dto->type->value : null ,
                    start_date: $dto->start_date,
                    end_date: $dto->end_date,
                )
            );

            return $regionEconomicFactor;
        });

        return $model;
    }

    // public function findModelRegionEconomicFactor(CreateRegionEconomicFactorDTO $dto) : ?RegionEconomicFactor
    // {
    //     return RegionEconomicFactor::where('region_name_start', $dto->region_name_start)
    //         ->where('region_name_end', $dto->region_name_end )->first();
    // }

    public function createRegionEconomicFactor(RegionEconomicFactorVO $vo) : RegionEconomicFactor
    {
        return CreateRegionEconomicFactorAction::make($vo);
    }

    public function findGarIdInMatrixDistance(CreateRegionEconomicFactorDTO $dto) : ?MatrixDistance
    {
        return MatrixDistance::where('city_name_start', $dto->region_name_start)
            ->where('city_name_end', $dto->region_name_end )->first();
    }


}
