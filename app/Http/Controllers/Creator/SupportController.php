<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSupportRequest;
use App\Models\Support;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SupportController extends Controller
{
    /**
     * Mostrar apoyos recibidos (dashboard).
     */
    public function index(Request $request)
    {
        return Inertia::render('Dashboard/Supports', [
            'supports' => $request->user()->supports()->latest()->get(),
        ]);
    }

    /**
     * Guardar un apoyo desde la página pública del creador.
     */
    public function storePublic(StoreSupportRequest $request, $slug)
    {
        $creator = User::where('slug', $slug)->firstOrFail();

        $creator->supports()->create($request->validated());

        return redirect()->back()->with('success', '¡Gracias por tu apoyo!');
    }
}
