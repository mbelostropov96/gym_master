<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateTrainingRequest;
use App\Http\Requests\StoreTrainingRequest;
use App\Models\Training;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

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
     * @param Request $request
     * @return Renderable
     */
    public function create(Request $request): Renderable
    {
        $trainingTemplateIds = $request->get('training_template_id');

        $instructors = (new User())->newQuery()
            ->where('role', '=', UserRole::INSTRUCTOR->value)
            ->get();

        return view('', [
            'trainingTemplateIds' => $trainingTemplateIds,
            'instructors' => $instructors,
        ]);
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
