// Validación básica para edición de productos

document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector("form");

    form.addEventListener("submit", (e) => {
        const nombre = form.nombre.value.trim();
        const codigo = form.codigo.value.trim();

        if (!nombre || !codigo) {
            e.preventDefault();
            alert("Por favor, completa los campos obligatorios.");
        }
    });
});
