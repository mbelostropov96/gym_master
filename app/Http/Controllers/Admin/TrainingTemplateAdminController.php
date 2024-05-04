<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTrainingTemplateRequest;
use App\Http\Requests\UpdateTrainingTemplateRequest;
use App\Models\TrainingTemplate;
use App\View\Components\Admin\TrainingTemplate\CreateTrainingTemplate as CreateTrainingTemplateComponent;
use App\View\Components\Admin\TrainingTemplate\TrainingTemplateCard as TrainingTemplateCardComponent;
use App\View\Components\Admin\TrainingTemplate\TrainingTemplates as TrainingTemplatesComponent;
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

        $trainingTemplatesComponent = new TrainingTemplatesComponent($trainingTemplates);

        return $trainingTemplatesComponent->render()->with($trainingTemplatesComponent->data());
    }

    /**
     * @param int $id
     * @return Renderable
     */
    public function show(int $id): Renderable
    {
        /** @var TrainingTemplate $trainingTemplate */
        $trainingTemplate = (new TrainingTemplate())->newQuery()
            ->findOrFail($id);

        $trainingTemplateComponent = new TrainingTemplateCardComponent($trainingTemplate);

        return $trainingTemplateComponent->render()->with($trainingTemplateComponent->data());
    }

    /**
     * @return Renderable
     */
    public function create(): Renderable
    {
        $createTrainingTemplateComponent = new CreateTrainingTemplateComponent();

        return $createTrainingTemplateComponent->render();
    }

    /**
     * @param StoreTrainingTemplateRequest $request
     * @return RedirectResponse
     */
    public function store(StoreTrainingTemplateRequest $request): RedirectResponse
    {
        $data = $request->validated();

        (new TrainingTemplate())->newQuery()
            ->create($data);

        return redirect()->to(route('admin.training-templates.index'));
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

        return redirect()->to(route('admin.training-templates.show', ['id' => $id]));
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

        return redirect()->to(route('admin.training-templates.index'));
    }
}
