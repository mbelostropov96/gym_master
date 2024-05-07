<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTariffRequest;
use App\Http\Requests\UpdateTariffRequest;
use App\Models\Tariff;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;

class TariffAdminController extends Controller
{
    /**
     * @return Renderable
     */
    public function index(): Renderable
    {
        $tariffs = (new Tariff())->newQuery()
            ->get();

    }

    /**
     * @param int $id
     * @return Renderable
     */
    public function show(int $id): Renderable
    {
        /** @var Tariff $tariff */
        $tariff = (new Tariff())->newQuery()
            ->findOrFail($id);

    }

    /**
     * @return Renderable
     */
    public function create(): Renderable
    {

    }

    /**
     * @param StoreTariffRequest $request
     * @return RedirectResponse
     */
    public function store(StoreTariffRequest $request): RedirectResponse
    {
        $data = $request->validated();

        (new Tariff())->newQuery()
            ->create($data);

    }

    /**
     * @param int $id
     * @param UpdateTariffRequest $request
     * @return RedirectResponse
     */
    public function update(int $id, UpdateTariffRequest $request): RedirectResponse
    {
        $data = $request->validated();

        (new Tariff())->newQuery()
            ->findOrFail($id)
            ->update($data);

    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        (new Tariff())->newQuery()
            ->findOrFail($id)
            ->delete();

    }
}
