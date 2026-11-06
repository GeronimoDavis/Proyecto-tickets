<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Gestión de Tickets de Soporte</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">

  @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

  <div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2><i class="fa-solid fa-headset me-2"></i>Gestión de Tickets de Soporte</h2>
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevoTicketModal">
        <i class="fa-solid fa-plus me-1"></i> Nuevo Ticket
      </button>
    </div>

<!-- Tabla para mostrar los datos-->
    <div class="table-responsive shadow-sm">
      <table class="table table-striped table-hover align-middle">
        <thead class="table-dark">
          <tr>
            <th>ID</th>
            <th>Usuario</th>
            <th>Título</th>
            <th>Categoría</th>
            <th>Prioridad</th>
            <th>Estado</th>
            <th>Fecha Límite</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($tickets as $ticket)
            <tr>
              <td>{{$ticket->ticket_id}}</td>
              <td>{{$ticket->user->name}}</td>
              <td>{{$ticket->title}}</td>
              <td><span class="badge bg-info text-dark">{{$ticket->category}}</span></td>
              <td><span class="badge bg-danger">{{$ticket->priority}}</span></td>
              <td><span class="badge bg-warning text-dark">{{$ticket->status}}</span></td>
              <td>{{$ticket->due_date}}</td>
              <td>
                <button class="btn btn-sm btn-outline-secondary me-2" data-bs-toggle="modal" data-bs-target="#verImagenModal-{{ $ticket->ticket_id }}" title="Ver Imagen">
                  <i class="fa-regular fa-image"></i>
                </button>

                <form method="POST" action="{{ route('ticket_update_status', $ticket->ticket_id) }}" class="d-inline">
                    @csrf
                    @method('PATCH')

                    @if($ticket->status == 'abierto')
                        <input type="hidden" value="en_proceso" name="status">
                    @elseif($ticket->status == 'en_proceso')
                        <input type="hidden" value="resuelto" name="status">
                    @elseif($ticket->status == 'resuelto')
                        <input type="hidden" value="cerrado" name="status">
                    @else
                        <input type="hidden" value="cerrado" name="status">
                    @endif                  
                    <button class="btn btn-sm btn-outline-success me-2" title="Subir Estado" type="submit">
                        <i class="fa-solid fa-up-long"></i>
                    </button>
                </form>

                <form method="POST" action="{{ route('ticket_cancelar', $ticket->ticket_id) }}" class="d-inline">
                  @csrf
                  @method('PATCH')
                  <button class="btn btn-sm btn-outline-danger me-2" title="Cancelar Ticket">
                    <i class="fa-solid fa-ban"></i>
                    @if($ticket->cancelado) disabled @endif
                  </button>

                </form>
              </td>
            </tr>
        @endforeach
        </tbody>
      </table>
    </div>
  </div>

  <!--Modal de nuevo ticket -->

  <div class="modal fade" id="nuevoTicketModal" tabindex="-1" aria-labelledby="nuevoTicketModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="nuevoTicketModalLabel">
            <i class="fa-solid fa-plus-circle me-2"></i>Crear Nuevo Ticket
          </h5>
          <!-- boton de cierra el modal X -->
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
           <!-- FORMULARIO -->
        <form method="POST" action="{{ route('store_ticket') }}" enctype="multipart/form-data">
          @csrf
          
          <!-- titulo -->
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Título</label>
                <input name="title" type="text" class="form-control" placeholder="Ingrese el título del ticket">
              </div>
        <!-- seleccion de usuario -->
        <div class="col-md-6">
            <label for="usuarioTicket" class="form-label">
              <i class="fa-solid fa-user me-1"></i> Usuario asignado
            </label>
            <select name="user_id" class="form-select" id="usuarioTicket" name="usuario_id" required>
              <option value="" selected disabled>
                Seleccione un usuario
              </option>
              @foreach ($users as $user)
                <option value="{{$user->id}}">{{$user->name}}</option>
              @endforeach
          </select>
        </div>
      </div>
      <!-- categoria  -->
      <div class="row g-3">
                    <div class="col-md-12">
                      <label class="form-label">Categoría</label>
                      <select name="category" class="form-select">
                        <option value="soporte">Soporte</option>
                        <option value="mantenimiento">Mantenimiento</option>
                        <option value="instalacion">Instalación</option>
                        <option value="otro">Otro</option>
                      </select>
                    </div>
                    <!-- descripcion -->
                    <div class="col-12">
                      <label class="form-label">Descripción</label>
                      <textarea name="description" class="form-control" rows="3" placeholder="Describa el problema..."></textarea>
                    </div>
                    <!-- prioridad -->
                    <div class="col-md-4">
                      <label class="form-label">Prioridad</label>
                      <select name="priority" class="form-select">
                        <option value="baja">Baja</option>
                        <option value="media">selected>Media</option>
                        <option value="alta">Alta</option>
                        <option value="critica">Crítica</option>
                      </select>
                    </div>
                    <!-- fecha limite -->
                    <div class="col-md-4">
                      <label class="form-label">Fecha Límite</label>
                      <input name="due_date" type="date" class="form-control">
                    </div>
                    <!-- imagen -->
                    <div class="col-md-4">
                      <label class="form-label">Imagen (opcional)</label>
                      <input name="image_path" type="file" class="form-control" accept="image/*">
                    </div>
                  </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
      </form>
      </div>
    </div>
  </div>

<!-- modal para ver las imagenes que se conecta con el boton por la id y muestra la imagen de cada ticket-->
 @foreach ($tickets as $ticket)
  <div class="modal fade" id="verImagenModal-{{$ticket->ticket_id}}" tabindex="-1" aria-labelledby="verImagenModalLabel-{{ $ticket->ticket_id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-dark text-white">
          <h5 class="modal-title" id="verImagenModalLabel-1">
            <i class="fa-regular fa-image me-2"></i>Imagen del Ticket {{$ticket->ticket_id}}  del Usuario: {{ $ticket->user->name }}
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body text-center">
        <!--verificamos si tiene imagen el ticket -->
          @if ($ticket->image_path)
            <img src="{{ route('ticket_image', $ticket->ticket_id) }}" class="img-fluid rounded" alt="Imagen Ticket {{ $ticket->ticket_id }}">
          @else
            <i class="fa-solid fa-image-slash me-2"></i>Este ticket no posee una imagen adjunta.
          @endif        
        </div>
      </div>
    </div>
  </div>
@endforeach

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
