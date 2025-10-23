<style>
input[type=file]::file-selector-button {
  margin-right: 20px;
  border: none;
  background: #084cdf;
  padding: 10px 20px;
  border-radius: 10px;
  color: #fff;
  cursor: pointer;
  transition: background .2s ease-in-out;
}

input[type=file]::file-selector-button:hover {
  background: #0d45a5;
}

</style>

<div>
    <div class="container">
        <div class="row">
            <div class="col-1"></div>
            <div class="col-10 py-5">
                <div class="card my-5">

                    <div class="card-body">
                        <form method="POST" action="{{ route('back.bancos.import') }}" enctype="multipart/form-data">
                            @method('POST')
                            @csrf
                            <div class="mb-3">
                                <label for="formFileLg" class="form-label"></label>
                                <input name="excel_file" class="form-control form-control-lg" id="formFileLg" required
                                       type="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                            </div>
                            <div class="mb-3 text-end">
                                <button type="submit" value="submit" class="btn btn-primary ">Subir</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-1"></div>
        </div>
    </div>
</div>
