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

  <div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2><i class="fa-solid fa-headset me-2"></i>Gestión de Tickets de Soporte</h2>
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevoTicketModal">
        <i class="fa-solid fa-plus me-1"></i> Nuevo Ticket
      </button>
    </div>

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
                <button class="btn btn-sm btn-outline-success me-2" title="Subir Estado">
                  <i class="fa-solid fa-up-long"></i>
                </button>
                <button class="btn btn-sm btn-outline-danger me-2" title="Cancelar Ticket">
                  <i class="fa-solid fa-ban"></i>
                </button>
              </td>
            </tr>
        @endforeach
        </tbody>
      </table>
    </div>
  </div>

  <div class="modal fade" id="nuevoTicketModal" tabindex="-1" aria-labelledby="nuevoTicketModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="nuevoTicketModalLabel">
            <i class="fa-solid fa-plus-circle me-2"></i>Crear Nuevo Ticket
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <form>
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Título</label>
                <input type="text" class="form-control" placeholder="Ingrese el título del ticket">
              </div>

	<div class="col-md-6">
  		<label for="usuarioTicket" class="form-label">
    		<i class="fa-solid fa-user me-1"></i> Usuario asignado
  		</label>
  		<select class="form-select" id="usuarioTicket" name="usuario_id" required>
    		<option value="" selected disabled>
      		Seleccione un usuario
    		</option>
    		<option value="1">Juan Pérez</option>
    		<option value="2">María López</option>
    		<option value="3">Carlos Ruiz</option>
  	</select>
	</div>
</div>
<div class="row g-3">
              <div class="col-md-12">
                <label class="form-label">Categoría</label>
                <select class="form-select">
                  <option>Soporte</option>
                  <option>Mantenimiento</option>
                  <option>Instalación</option>
                  <option>Otro</option>
                </select>
              </div>
              <div class="col-12">
                <label class="form-label">Descripción</label>
                <textarea class="form-control" rows="3" placeholder="Describa el problema..."></textarea>
              </div>
              <div class="col-md-4">
                <label class="form-label">Prioridad</label>
                <select class="form-select">
                  <option>Baja</option>
                  <option selected>Media</option>
                  <option>Alta</option>
                  <option>Crítica</option>
                </select>
              </div>
              <div class="col-md-4">
                <label class="form-label">Fecha Límite</label>
                <input type="date" class="form-control">
              </div>
              <div class="col-md-4">
                <label class="form-label">Imagen (opcional)</label>
                <input type="file" class="form-control" accept="image/*">
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary">Guardar</button>
        </div>
      </div>
    </div>
  </div>
<!-- modal para ver las imagenes-->
  <div class="modal fade" id="verImagenModal-1" tabindex="-1" aria-labelledby="verImagenModalLabel-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-dark text-white">
          <h5 class="modal-title" id="verImagenModalLabel-1">
            <i class="fa-regular fa-image me-2"></i>Imagen del Ticket #1
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body text-center">
          <img src="1.png" class="img-fluid rounded" alt="Imagen Ticket 1">
        </div>
      </div>
    </div>
  </div>

 <div class="modal fade" id="verImagenModal-2" tabindex="-1" aria-labelledby="verImagenModalLabel-2" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-dark text-white">
          <h5 class="modal-title" id="verImagenModalLabel-2">
            <i class="fa-regular fa-image me-2"></i>Imagen del Ticket #2
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body text-center">
          <img src="2.png" class="img-fluid rounded" alt="Imagen Ticket 2">
        </div>
      </div>
    </div>
  </div>

<div class="modal fade" id="verImagenModal-3" tabindex="-1" aria-labelledby="verImagenModalLabel-3" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-dark text-white">
          <h5 class="modal-title" id="verImagenModalLabel-3">
            <i class="fa-regular fa-image me-2"></i>Imagen del Ticket #3
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body text-center">
          <img src="3.png" class="img-fluid rounded" alt="Imagen Ticket 3">
        </div>
      </div>
    </div>
  </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
