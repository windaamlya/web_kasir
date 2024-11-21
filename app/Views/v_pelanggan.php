<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasirci4</title>
    <script src="<?= base_url('asset/jquery-3.7.1.min.js') ?>"></script>
    <link rel="stylesheet" href="<?= base_url('asset/bootstrap-5.0.2-dist/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('asset/fontawesome-free-6.6.0-web/fontawesome-free-6.6.0-web/css/all.min.css') ?>">
</head>
<body>
<div class="container mt-5"> 
    <div class="row mt-3">
        <div class="col-12">
            <h3 class="text-center">Data Pelanggan</h3>
            <button type="button" class="btn btn-success float-end" data-bs-toggle="modal" data-bs-target="#modalTambahPelanggan">
                <i class="fa-solid fa-user"></i> Tambah Pelanggan
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="container mt-5">
                <table class="table table-bordered" id="pelangganTabel">
                    <thead> 
                        <tr>
                            <th>ID</th>
                            <th>Nama Pelanggan</th>
                            <th>Alamat</th>
                            <th>No Telepon</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data akan dimasukkan melalui ajax -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Pelanggan -->
    <div class="modal fade" id="modalTambahPelanggan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalTambahPelangganLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white"> 
                    <h1 class="modal-title fs-5" id="modalTambahPelangganLabel">Tambah Pelanggan</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formPelanggan">
                        <div class="row mb-3">
                            <label for="namaPelanggan" class="col-sm-4 col-form-label">Nama Pelanggan</label>
                            <div class="col-sm-8"> 
                                <input type="text" class="form-control" id="namaPelanggan" name="namaPelanggan">
                            </div>
                        </div>
                        <div class="row mb-3"> 
                            <label for="alamatPelanggan" class="col-sm-4 col-form-label">Alamat</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="alamatPelanggan" name="alamatPelanggan">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="NoTelepon" class="col-sm-4 col-form-label">No. Telepon</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="no_tlp" name="no_tlp">
                            </div>
                        </div>
                        <button type="button" id="simpanPelanggan" class="btn btn-primary float-end">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Pelanggan -->
    <div class="modal fade" id="modalEditPelanggan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalEditPelangganLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white"> 
                    <h1 class="modal-title fs-5" id="modalEditPelangganLabel">Edit Pelanggan</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditPelanggan">
                        <input type="hidden" id="editPelangganId">
                        <div class="row mb-3">
                            <label for="editnamaPelanggan" class="col-sm-4 col-form-label">Nama Pelanggan</label>
                            <div class="col-sm-8"> 
                                <input type="text" class="form-control" id="editnamaPelanggan" name="editnamaPelanggan">
                            </div>
                        </div>
                        <div class="row mb-3"> 
                            <label for="editalamatPelanggan" class="col-sm-4 col-form-label">Alamat Pelanggan</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="editalamatPelanggan" name="editalamatPelanggan">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="editNoTeleponPelanggan" class="col-sm-4 col-form-label">No Telepon</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="editNoTeleponPelanggan" name="editNoTeleponPelanggan">
                            </div>
                        </div>
                        <button type="button" id="updatePelanggan" class="btn btn-primary float-end">Edit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function tampilPelanggan() {
        $.ajax({
            url: '<?= base_url('pelanggan/tampil'); ?>',
            type: "GET",
            dataType: 'json',
            success: function(hasil) {
                if (hasil.status === "success") {
                    var pelangganTable = $('#pelangganTabel tbody');
                    pelangganTable.empty();
                    var pelanggan = hasil.pelanggan;
                    var no = 1;
                    pelanggan.forEach(function(item) {
                        var row = `<tr>
                            <td>${no}</td>
                            <td>${item.nama_pelanggan}</td>
                            <td>${item.alamat}</td>
                            <td>${item.no_tlp}</td>
                            <td>
                                <button class="btn btn-warning btn-edit editPelanggan" data-bs-toggle="modal" data-bs-target="#modalEditPelanggan" data-id="${item.id_pelanggan}"><i class="fa-solid fa-pen-to-square"></i> Edit</button>
                                <button class="btn btn-danger btn-hapus" data-id="${item.id_pelanggan}"><i class="fa-solid fa-trash-can"></i> Hapus</button>
                            </td>
                        </tr>`;
                        // console.log(item.Id_pelanggan);
                        
                        pelangganTable.append(row);
                        no++;
                    });
                } else {
                    alert('Gagal mengambil data.');
                }
            },
            error: function(xhr, status, error) {
                alert('Terjadi kesalahan: ' + error);
            }
        });
    }

    $(document).ready(function() {
        tampilPelanggan();

        $("#simpanPelanggan").on("click", function() {
            var formData = {
                nama_pelanggan: $("#namaPelanggan").val(),
                alamat: $('#alamatPelanggan').val(),
                no_tlp: $('#no_tlp').val() 
            };

            $.ajax({
                url: '<?= base_url('pelanggan/simpan'); ?>',
                type: "POST",
                data: formData,
                dataType: 'json',
                success: function(hasil) {
                    if (hasil.status === 'success') {
                        Swal.fire({
                            title: "Good job!",
                            text: "Pelanggan berhasil ditambahkan!",
                            icon: "success"
                        });
                        $('#modalTambahPelanggan').modal("hide");
                        $('#formPelanggan')[0].reset();
                        tampilPelanggan();
                    } else {
                        alert('Gagal menyimpan data: ' + JSON.stringify(hasil.errors));
                    }
                },
                error: function(xhr, status, error) {
                    alert('Terjadi kesalahan: ' + error);
                }
            });
        });

        $(document).on('click', '.btn-hapus', function() { //Event handler ketika tombol hapus diklik. ID produk yang akan dihapus diambil dari atribut data-id.
                var row = $(this).closest('tr');
                document.get
                var id = $(this).data('id');
                if (confirm("Apakah Anda yakin ingin menghapus produk ini?")) {//Memunculkan konfirmasi kepada pengguna untuk memastikan apakah mereka yakin ingin menghapus produk.
                    Swal.fire({
                        title: "Are you sure?",
                        text: "You won't be able to revert this!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, delete it!"
                        }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                            title: "Deleted!",
                            text: "Your file has been deleted.",
                            icon: "success"
                            });
                        }
                        });
                    $.ajax({ //Memunculkan konfirmasi kepada pengguna untuk memastikan apakah mereka yakin ingin menghapus produk.
                        url: '<?= base_url('pelanggan/hapus/') ?>' + id,
                        type: "DELETE",
                        dataType: 'json',
                        success: function(response) { //Jika berhasil, baris produk akan dihapus dari tabel dan tabel diperbarui.
                            console.log(response);
                            if (response.success) {
                                row.remove();
                                alert("Produk berhasil dihapus.");
                                tampilPelanggan();
                            } else {
                                alert("Gagal menghapus produk.");
                            }
                        },
                        error: function(xhr, status, error) {
                            alert("Terjadi kesalahan saat menghapus: " + error);
                        }
                    });
                }
            });
    });

    $(document).on("click", ".editPelanggan", function(){ //Event handler untuk tombol edit produk. Ketika tombol edit diklik, ID produk diambil dan digunakan untuk mengambil data produk dari server untuk diedit.
                    var id = $(this).data("id"); // Ambil ID dari tombol yang diklik
                    $.ajax({//Request GET ke server untuk mengambil data produk berdasarkan ID yang dikirimkan.
                        url: '<?= base_url('pelanggan/edit')?>',
                        type: 'GET',
                        data: { id: id }, // Kirim ID ke server
                        dataType: 'json',
                        success: function(hasil) {
                            console.log(hasil);
                            if (hasil) { // Isi input modal dengan data produk
                                $("#editPelangganId").val(hasil.id_pelanggan); // Pastikan ID diisi
                                $("#editnamaPelanggan").val(hasil.nama_pelanggan);
                                $("#editalamatPelanggan").val(hasil.alamat);
                                $("#editNoTeleponPelanggan").val(hasil.no_tlp);
                                $("#modalEditPelanggan").modal("show"); //Menampilkan modal edit produk dengan data yang sudah diisi.
                            } else {
                                alert('Gagal mengambil data untuk diedit.');
                            }
                        },
                        error: function(xhr, status, error) {
                            alert('Terjadi kesalahan: ' + error);
                        }
                        
                    });
                });
        

            $("#updatePelanggan").on("click", function(e){
            var form={
                nama_pelanggan: $("#editnamaPelanggan").val(),
                alamat: $("#editalamatPelanggan").val(),
                no_tlp: $("#editNoTeleponPelanggan").val(),
                id_pelanggan:$('#editPelangganId').val()
            }   

            $.ajax({
                url:"<?=base_url("pelanggan/update")?>",
                data:form,
                dataType:'json',
                type:'POST',
                success:function(hasil){
                    Swal.fire({
                                title: "Good job!",
                                text: "You clicked the button!",
                                icon: "success"
                                });
                    $("#modalEditPelanggan").modal("hide");
                    tampilProduk()
                },

            })
        });
</script>

<script src="<?= base_url('asset/bootstrap-5.0.2-dist/js/bootstrap.min.js') ?>"></script>
<script src="<?= base_url('asset/fontawesome-free-6.6.0-web/fontawesome-free-6.6.0-web/js/all.min.js') ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>
</html>
