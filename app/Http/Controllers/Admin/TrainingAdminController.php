<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateTrainingRequest;
use App\Http\Requests\StoreTrainingRequest;
use App\Models\Training;
use App\Models\TrainingTemplate;
use App\Models\User;
use App\View\Components\Admin\CreateTraining as CreateTrainingComponent;
use App\View\Components\Admin\CreateTrainingByTemplate as CreateTrainingByTemplateComponent;
use App\View\Components\Admin\Trainings as TrainingsComponent;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use InvalidArgumentException;

class TrainingAdminController extends Controller
{
    /**
     * @return Renderable
     */
    public function index(): Renderable
    {
        $trainings = (new Training())->newQuery()
            ->with([
                'instructor',
            ])
            ->get();

        $instructors = (new User())->newQuery()
            ->where('role', '=', UserRole::INSTRUCTOR->value)
            ->get();

        $trainingsComponent = new TrainingsComponent($trainings, $instructors);

        return $trainingsComponent->render()->with($trainingsComponent->data());
    }

    /**
     * @param int $id
     * @return Renderable
     */
    public function show(int $id): Renderable
    {
        $training = (new Training())->newQuery()
            ->with([
                'instructor',
            ])
            ->findOrFail($id);

        return view('', [
            'training' => $training,
        ]);
    }

    /**
     * @return Renderable
     */
    public function create(): Renderable
    {
        $trainingTemplates = (new TrainingTemplate())->newQuery()
            ->get();

        $createTrainingComponent = new CreateTrainingComponent($trainingTemplates);

        return $createTrainingComponent->render()->with($createTrainingComponent->data());
    }

    /**
     * @param Request $request
     * @return Renderable
     */
    public function createByTemplate(Request $request): Renderable
    {
        if (null === $trainingTemplateId = $request->get('id')) {
            throw new InvalidArgumentException('toje loh', 322);
        }

        /** @var TrainingTemplate $trainingTemplate */
        $trainingTemplate = (new TrainingTemplate())->newQuery()
            ->findOrFail($trainingTemplateId);

        $instructors = (new User())->newQuery()
            ->where('role', '=', UserRole::INSTRUCTOR->value)
            ->get();

        $createTrainingByTemplateComponent = new CreateTrainingByTemplateComponent(
            $trainingTemplate,
            $instructors,
        );

        return $createTrainingByTemplateComponent->render()->with($createTrainingByTemplateComponent->data());
    }

    /**
     * @param StoreTrainingRequest $request
     * @return Renderable
     */
    public function store(StoreTrainingRequest $request): Renderable
    {
        $data = $request->validated();

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
        $data = $request->validated();

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
