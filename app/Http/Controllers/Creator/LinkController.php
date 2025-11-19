<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLinkRequest;
use App\Models\Link;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class LinkController extends Controller
{
    use AuthorizesRequests;

    /**
     * Mostrar lista de links del usuario.
     */
    public function index(Request $request)
    {
        return Inertia::render('Dashboard/Links', [
            'links' => $request->user()->links()->orderBy('position')->get(),
        ]);
    }

    /**
     * Crear un nuevo link.
     */
    public function store(StoreLinkRequest $request)
    {
        $link = new Link();
        $link->user_id = $request->user()->id;
        $link->title = $request->input('title');
        $link->url = $request->input('url');
        $link->position = $request->input('position', 0);
        $link->save();

        return redirect()->back()->with('success', 'Link creado correctamente.');
    }

    /**
     * Actualizar un link.
     */
    public function update(StoreLinkRequest $request, Link $link)
    {
        $this->authorize('update', $link);

        $link->update($request->validated());

        return redirect()->back()->with('success', 'Link actualizado.');
    }

    /**
     * Eliminar link.
     */
    public function destroy(Link $link)
    {
        $this->authorize('delete', $link);

        $link->delete();

        return redirect()->back()->with('success', 'Link eliminado.');
    }

    /**
     * Reordenar links.
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'links' => 'required|array',
            'links.*.id' => 'required|exists:links,id',
            'links.*.position' => 'required|integer|min:0',
        ]);

        foreach ($request->input('links') as $linkData) {
            $link = Link::findOrFail($linkData['id']);
            
            // Verificar que el link pertenece al usuario autenticado
            $this->authorize('update', $link);
            
            $link->position = $linkData['position'];
            $link->save();
        }

        return redirect()->route('links.index')->with('success', 'Orden actualizado correctamente.');
    }
}
