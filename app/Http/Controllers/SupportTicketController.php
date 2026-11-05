<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupportTicket;
use App\Http\Requests\StoreSupportTicketRequest;
use App\Http\Requests\UpdateSupportTicketRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class SupportTicketController extends Controller
{
    /** 
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        $tickets = SupportTicket::with('user')->get();//una sola consulta adicional para traer los usuarios cuyo id coincida con los user_id de los tickets recuperados

        return view('index', compact('tickets', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // no usamos esta funcion la cual retorna el formulario para crear un ticket porque el formulario ya esta integrado en el index
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validamos los datos del html

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',// el id existe en la table users?
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category'   => 'required|in:soporte,mantenimiento,instalacion,otro',//rechaza otro valor que no este en la lista
            'priority'   => 'required|in:baja,media,alta,critica',
            'due_date'   => 'required|date',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        
        if($request->hasFile('image_path')){//como es opcional la foto validamos si se subio bien y esta
            $path = $request->file('image_path')->store('tickets', 'local');//store guarda la foto y devuelve la ruta de la imagen y es la que guardamos en la base de datos
            $validated['image_path'] = $path;//remplazamos el image_path (el cual es el objeto imagen) por la url que nos dio store en el array $validate
        }

        SupportTicket::create($validated);

        return redirect()->route('index_ticket');
    }


    public function showImage($id)
    {
        //buscamos el ticket que queremos ver la imagen
        $ticket = SupportTicket::findOrFail($id);

        //verificamos si el ticket tiene imagen y si el archivo existe en el disco privado
        if($ticket->image_path && Storage::disk('local')->exists($ticket->image_path)){

            // Obtenemos la ruta absoluta en disco y la servimos
            $path = Storage::disk('local')->path($ticket->image_path);

            return response()->file($path);
        }
        
       abort(404);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SupportTicket $supportTicket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSupportTicketRequest $request, SupportTicket $supportTicket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SupportTicket $supportTicket)
    {
        //
    }
}
