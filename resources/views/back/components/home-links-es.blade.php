<div class="card mb-2">
    <div class="card-header">
        <div class="row">
            <div class="col">Hipervínculos</div>

            <div class="col fs-5 text-end">
                <img src="{{ asset('img/icons/link.png') }}" />
                <img src="{{ asset('img/icons/home.png') }}" />
            </div>
        </div>
    </div>

    <div class="card-body p-2">
        <p>
            Esta tarjeta puede ser utilizada para mostrar todo tipo de 
           <b>hipervínculos</b> o botones para navegar rápidamente a ciertas 
           partes de su aplicación.
        </p>

        <div class="alert alert-secondary p-2" role="alert">
            Esta aplicación requiere al menos <a href="https://www.php.net/" target="_blank">PHP 8.2</a> y esta desarrollada
            usando:
            <ul>
                <li><a href="https://laravel.com/" target="_blank">Laravel</a> 11.x (featuring <a
                        href="https://vitejs.dev/" target="_blank">Vite</a>)</li>
                <li><a href="https://getbootstrap.com/" target="_blank">Bootstrap</a> 5.x</li>
                <li><a href="https://datatables.net/" target="_blank">DataTables</a> 2.x</li>
            </ul>
        </div>

        <div class="alert alert-secondary p-2" role="alert">
            <b>Atributos:</b> 
            <ul>
                <li><b>Barra superior de botones</b> para navegar rápidamente a las partes principales de su aplicación</li>
                <li><b>Alternar tema :</b> : Claro / Oscuro</li>
                <li><b>Offcanvas menu</b>  para acceder a opciones utilizadas con menos frecuencia</li>
                <li><b>Datatables</b>, Totalmente integradas al sistema con las siguientes características:</li>
                <ul>
                    <li>Create - Show - Update - Delete (CRUD) usando diálogos con
                        <a href="http://bootboxjs.com/" target="_blank">Bootbox.js</a> y notificaciones con 
                        <a href="https://codeseven.github.io/toastr/" target="_blank">Toastr</a>
                    </li>
                    <li>Copiar al portapapeles</li>
                    <li>Exportar a Excel</li>
                    <li>Función de impresión</li>
                    <li>Selector de items por página</li>
                    <li>Selector de visibilidad de columna</li>
                    <li>Busquedas con resultados resaltados</li>
                    <li>Paginación y filtrado del lado del servidor</li>
                    <li>Selección de varias filas (para eliminaciones masivas)</li>
                    <li>Campo booleano conmutable</li>
                    <li>Ayuda</li>
                </ul>
            </ul>
            <hr />
            <b>Característica especial :</b>
            <p>El menú superior contiene en su centro un selector desplegable para el año. 
                Esto se implementa como una variable de sesión global <b>[APP].[AÑO]</b> y le 
                permite filtrar fácilmente la data de las tablas (cuando sea necesario) 
                para reflejar únicamente aquellos datos relacionados con el año seleccionado. Esto es extremadamente útil 
                si gestionas modelos que dependen del año, como por ejemplo despachos, pedidos, producciones, etc.
            </p>
        </div>
    </div>

    <div class="card-footer">
        <div class="row d-flex align-items-center">
            <div class="col text-danger">
                <h5 id="MyClockTime" onload="showDate();"></h5>
            </div>

            <div class="col text-end">
                <h5 id="MyClockDate" onload="showDate();"></h5>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script type="module">
        /* -------------------------------------------------------------------------------------------- */
        showTime();
        showDate();

        function showTime() {
            const now = dayjs();

            let h = now.hour();
            let m = now.minute();
            let s = now.second();

            if (h == 0 && m == 0 && s == 0) {
                showDate();
            }

            h = (h < 10) ? "0" + h : h;
            m = (m < 10) ? "0" + m : m;
            s = (s < 10) ? "0" + s : s;

            const time = h + ":" + m + ":" + s;
            document.getElementById("MyClockTime").textContent = time;

            setTimeout(showTime, 1000);
        }

        function showDate() {
            const now = dayjs();

            let d = now.date();
            let m = now.month() + 1;
            let y = now.year();

            d = (d < 10) ? "0" + d : d;
            m = (m < 10) ? "0" + m : m;

            const date = d + "-" + m + "-" + y;
            document.getElementById("MyClockDate").textContent = date;
        }
        /* -------------------------------------------------------------------------------------------- */
    </script>
@endpush
