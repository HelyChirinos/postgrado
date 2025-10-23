<div class="card mb-2">
    <div class="card-header">
        <div class="row">
            <div class="col">Status <strong>{{ Session::get('APP.YEAR') }}</strong></div>

            <div class="col fs-5 text-end">
                <img src="{{ asset('img/icons/statistics.png') }}" />
                <img src="{{ asset('img/icons/home.png') }}" />
            </div>
        </div>
    </div>

    <div class="card-body p-2">
        <p>
           
            Este lado de la tarjeta puede ser utlizada para mostrar todo tipo de indicadores ó <b>status</b> 
             y obtener una descripción general rápida de la aplicación.
        </p>

        <div class="alert alert-danger p-2" role="alert">
            <p>En este Proyecto tenemos, 3 modelos que han sido implementados :</p>
            <ul>
                <li><a href="{{ route('back.customers.index') }}">CLientes</a>, disponible para todos los usuarios que ingresen al sistema</li>
                <br />
                <li><a href="{{ route('back.users.index') }}">Usuarios</a> y <a
                        href="{{ route('back.userslog.index') }}">Users Log</a> o control de usuarios, 
                        disponible unicamente para aquellos usuarios registrado con la propiedad de 
                       <b>Programador</b>
                </li>
            </ul>
            <p>Utilice sus controladores y las vistas correspondientes como base para crear nuevas tablas de datos utilizando sus propios modelos de proyecto..</p>
        </div>

        <div class="alert alert-secondary p-2" role="alert">
            <p>Esta aplicación también tiene una función incorporada (solo disponible cuando el usuario es <b>Programador</b>) :</p>
            <ul>
                <li><a href="{{ url('/back/developer/log-monitor') }}" target="_blank">Log Viewer</a> ó monitor de Ingreso de Usuarios</li>
                <li><a href="{{ route('back.backups.index') }}">Backup manager</a> para realizar y descargar respaldo de la Base de Datos</li>
            </ul>
        </div>

        <br />
        <p>Código abierto bajo Licencia MIT .</p>

        <div class="alert alert-info p-2" role="alert">
            Especial Agradecimiento a <a href="https://www.kreaweb.be" target="_blank" tabindex="-1">kreaweb.be</a> quien aporto la base de este proyecto y considere darle una estrella en <a
                href="https://github.com/MGeurts/laravel-10-bootstrap-5-datatables" target="_blank">GitHub</a>. Gracias.
        </div>

        <p>Feliz programación...</p>

        <div class="float-end">
            <table>
                <tr>
                    <td class="text-end">
                    Diseño & desarrollo por<br />
                        <a href="https://www.kreaweb.be" target="_blank" tabindex="-1">kreaweb.be</a> e Ing. Hely Chirinos
                    </td>
                    <td>
                        <a href="https://www.kreaweb.be" title="kreaweb.be" target="_blank" tabindex="-1">
                            <img src="{{ asset('img/logo/kreaweb-035.png') }}" alt="kreaweb.be" />
                        </a>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="card-footer">
        <div class="row ">
            <div class="col small">
                <a href="https://www.yourcompany.com" target="_blank">www.tu-empresa.com</a>
            </div>

            <div class="col small text-end d-none d-md-block">
                Telefono : +58 0251 262-65-61<br />
                Celular : +58 414 533-13-32
            </div>

            <div class="col text-end">
                 HC-Sofware<br/>2121 Calle San Rafael<br />3023 Cabudare</br>Lara<br />Venezuela
            </div>
        </div>
    </div>
</div>
