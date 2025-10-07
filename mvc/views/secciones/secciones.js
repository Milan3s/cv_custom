document.addEventListener("DOMContentLoaded", () => {
  const seccionModal = document.getElementById("modalSeccion");
  if (!seccionModal) return;

  const modalTitle = seccionModal.querySelector(".modal-title");
  const modalDesc  = seccionModal.querySelector(".modal-desc");
  const form       = seccionModal.querySelector("form");
  const btnAccion  = seccionModal.querySelector(".btn-accion");

  const campoSelect = seccionModal.querySelector("#campoSelect");
  const campoTitulo = seccionModal.querySelector("#campoTitulo");
  const campoIcono  = seccionModal.querySelector("#campoIcono");

  const hiddenNombre = form.querySelector("input[name='nombre']");
  const hiddenAccion = form.querySelector("input[name='accion']");
  const tituloInput  = form.querySelector("input[name='titulo']");
  const iconoInput   = form.querySelector("input[name='icono']");
  const selectInput  = form.querySelector("select[name='seccion_id']");

  // ==============================
  // Abrir modal
  // ==============================
  document.querySelectorAll(".open-seccion-modal").forEach(btn => {
    btn.addEventListener("click", () => {
      const seccion = btn.dataset.seccion;
      const accion  = btn.dataset.action;

      // Reset campos visibles
      campoSelect.classList.add("d-none");
      campoTitulo.classList.add("d-none");
      campoIcono.classList.add("d-none");

      // Reset inputs
      form.reset();

      // Configuración dinámica
      hiddenNombre.value = seccion;
      hiddenAccion.value = accion;
      form.setAttribute("action", `views/secciones/${accion}.php`);

      // Títulos y descripciones
      const icons = { insert: "fa-plus-circle", update: "fa-edit", delete: "fa-trash-alt" };
      const texts = { insert: "Añadir Sección", update: "Editar Sección", delete: "Eliminar Sección" };

      modalTitle.innerHTML = `<i class="fas ${icons[accion]} me-2"></i>${texts[accion]} (${seccion})`;

      if (accion === "insert") {
        modalDesc.innerHTML = `<i class="fas fa-info-circle me-2"></i>
          Crea una nueva sección para <strong>${seccion}</strong>.`;
        campoTitulo.classList.remove("d-none");
        campoIcono.classList.remove("d-none");
      }

      if (accion === "update") {
        modalDesc.innerHTML = `<i class="fas fa-info-circle me-2"></i>
          Selecciona la sección de <strong>${seccion}</strong> que deseas modificar.`;
        campoSelect.classList.remove("d-none");
        campoTitulo.classList.remove("d-none");
        campoIcono.classList.remove("d-none");
      }

      if (accion === "delete") {
        modalDesc.innerHTML = `<i class="fas fa-info-circle me-2"></i>
          Selecciona la sección de <strong>${seccion}</strong> que deseas eliminar.
          <strong>Esta acción no se puede deshacer.</strong>`;
        campoSelect.classList.remove("d-none");
      }

      // Botón principal
      btnAccion.classList.remove("btn-outline-primary","btn-outline-success","btn-outline-danger");
      if (accion === "insert") btnAccion.classList.add("btn-outline-primary");
      if (accion === "update") btnAccion.classList.add("btn-outline-success");
      if (accion === "delete") btnAccion.classList.add("btn-outline-danger");

      btnAccion.innerHTML = `<i class="fas ${accion === "delete" ? "fa-trash-alt" : "fa-save"} me-1"></i>
        ${accion === "delete" ? "Eliminar" : "Guardar"}`;

      // Mostrar modal (única instancia)
      bootstrap.Modal.getOrCreateInstance(seccionModal).show();
    });
  });

  // ==============================
  // Autorellenar en EDITAR
  // ==============================
  if (selectInput) {
    selectInput.addEventListener("change", () => {
      if (hiddenAccion.value !== "update") return; // solo en editar
      const opt = selectInput.options[selectInput.selectedIndex];
      if (!opt || !opt.value) {
        tituloInput.value = "";
        iconoInput.value  = "";
        return;
      }
      tituloInput.value = opt.dataset.titulo || "";
      iconoInput.value  = opt.dataset.icono || "";
      hiddenNombre.value = opt.dataset.nombre || "";
    });
  }

  // ==============================
  // Reset al cerrar modal
  // ==============================
  seccionModal.addEventListener("hidden.bs.modal", () => {
    form.reset();
    campoSelect.classList.add("d-none");
    campoTitulo.classList.add("d-none");
    campoIcono.classList.add("d-none");
  });
});
