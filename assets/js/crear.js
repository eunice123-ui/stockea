// Validación básica para el formulario de creación de productos

document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector("form");

    form.addEventListener("submit", (e) => {
        const nombre = form.nombre.value.trim();
        const codigo = form.codigo.value.trim();

        if (!nombre || !codigo) {
            e.preventDefault();
            alert("Por favor, completa todos los campos obligatorios.");
        }
    });
});
