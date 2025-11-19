<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProfileController extends Controller
{
    /**
     * Mostrar el formulario de edición del perfil del creador.
     */
    public function edit(Request $request)
    {
        return Inertia::render('Dashboard/Profile', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Guardar los cambios del perfil del creador.
     */
    public function update(UpdateProfileRequest $request)
    {
        $request->user()->update($request->validated());

        return redirect()->back()->with('success', 'Perfil actualizado correctamente.');
    }

    /**
     * Mostrar la página pública del creador: /@slug
     */
    public function showPublic($slug)
    {
        $user = User::where('slug', $slug)->firstOrFail();

        return Inertia::render('Public/ShowCreator', [
            'creator' => $user,
            'links'   => $user->links()->orderBy('position')->get(),
        ]);
    }
}
