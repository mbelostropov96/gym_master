<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateTrainingRequest;
use App\Http\Requests\StoreTrainingRequest;
use App\Models\Training;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;

class TrainingAdminController extends Controller
{
    /**
     * @return Renderable
     */
    public function index(): Renderable
    {
        $trainings = (new Training())->newQuery()
            ->get();

        return view('', [
            'trainings' => $trainings,
        ]);
    }

    /**
     * @param int $id
     * @return Renderable
     */
    public function show(int $id): Renderable
    {
        $training = (new Training())->newQuery()
            ->findOrFail($id);

        return view('', [
            'training' => $training,
        ]);
    }

    /**
     * @param StoreTrainingRequest $request
     * @return Renderable
     */
    public function store(StoreTrainingRequest $request): Renderable
    {
        $data = $request->all();

        $training = (new Training())->newQuery()
            ->create($data);

        return view('', [
            'training' => $training,
        ]);
    }

    /**
     * @param int $id
     * @param UpdateTrainingRequest $request
     * @return RedirectResponse
     */
    public function update(int $id, UpdateTrainingRequest $request): RedirectResponse
    {
        $data = $request->all();

        (new Training())->newQuery()
            ->findOrFail($id)
            ->update($data);

        return redirect('');
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        (new Training())->newQuery()
            ->findOrFail($id)
            ->delete();

        return redirect('');
    }
}
