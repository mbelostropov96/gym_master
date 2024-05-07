<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTariffRequest;
use App\Http\Requests\UpdateTariffRequest;
use App\View\Components\Admin\Tariff\CreateTariff;
use App\View\Components\Admin\Tariff\TariffCard;
use App\View\Components\Admin\Tariff\Tariffs as TariffComponent;
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
            ->orderBy('discount')
            ->get();

        $tariffsComponent = new TariffComponent($tariffs);

        return $tariffsComponent->render()->with($tariffsComponent->data());
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

        $tariffCardComponent = new TariffCard($tariff);

        return $tariffCardComponent->render()->with($tariffCardComponent->data());
    }

    /**
     * @return Renderable
     */
    public function create(): Renderable
    {
        $tariffsComponent = new CreateTariff();

        return $tariffsComponent->render()->with($tariffsComponent->data());
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

        return redirect()->to(route('admin.tariffs.index'));
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

        return redirect()->to(route('admin.tariffs.show', ['id' => $id]));
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

        return redirect()->to(route('admin.tariffs.index'));
    }
}
