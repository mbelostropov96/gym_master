<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTrainingTemplateRequest;
use App\Http\Requests\UpdateTrainingTemplateRequest;
use App\Models\TrainingTemplate;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;

class TrainingTemplateAdminController extends Controller
{
    /**
     * @return Renderable
     */
    public function index(): Renderable
    {
        $trainingTemplates = (new TrainingTemplate())->newQuery()
            ->get();

        return view('', [
            'trainings' => $trainingTemplates,
        ]);
    }

    /**
     * @param int $id
     * @return Renderable
     */
    public function show(int $id): Renderable
    {
        $trainingTemplates = (new TrainingTemplate())->newQuery()
            ->findOrFail($id);

        return view('', [
            'training' => $trainingTemplates,
        ]);
    }

    /**
     * @param StoreTrainingTemplateRequest $request
     * @return Renderable
     */
    public function store(StoreTrainingTemplateRequest $request): Renderable
    {
        $data = $request->validated();

        $trainingTemplates = (new TrainingTemplate())->newQuery()
            ->create($data);

        return view('', [
            'training' => $trainingTemplates,
        ]);
    }

    /**
     * @param int $id
     * @param UpdateTrainingTemplateRequest $request
     * @return RedirectResponse
     */
    public function update(int $id, UpdateTrainingTemplateRequest $request): RedirectResponse
    {
        $data = $request->validated();

        (new TrainingTemplate())->newQuery()
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
        (new TrainingTemplate())->newQuery()
            ->findOrFail($id)
            ->delete();

        return redirect('');
    }
}
