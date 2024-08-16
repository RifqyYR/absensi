function hapusDataOrangTua(id) {
    const link = document.getElementById("deleteParentDataLink");
    link.href = "/data-orang-tua/hapus/" + id;
}

function hapusDataSiswa(id) {
    const link = document.getElementById("deleteStudentDataLink");
    link.href = "/data-siswa/hapus/" + id;
}

function hapusDataAbsensi(id) {
    const link = document.getElementById("deleteAbsenceDataLink");
    link.href = "/riwayat-absensi/hapus/" + id;
}

function hapusDataPelanggaran(id) {
    const link = document.getElementById("deleteViolationDataLink");
    link.href = "/data-siswa/detail/riwayat-pelanggaran/hapus/" + id;
}

function hapusDataUser(id) {
    const link = document.getElementById("deleteUserDataLink");
    link.href = "/user/hapus/" + id;
}

function validateInput(input) {
    input.value = input.value.replace(/\D/g, "");
}

function updateClock() {
    var now = new Date();
    var d = now.toLocaleTimeString();
    document.getElementById("liveClock").innerHTML = d;
}

function toggleCheckbox(event, id) {
    var isActionCol =
        event.target.classList.contains("action-col") ||
        event.target.parentElement.classList.contains("action-col") ||
        event.target.parentElement.parentElement.classList.contains(
            "action-col"
        );

    if (!isActionCol) {
        var checkbox = document.getElementById("checkbox" + id);
        checkbox.checked = !checkbox.checked;

        var checkboxes = document.getElementsByName("ids[]");
        var isChecked = Array.prototype.slice
            .call(checkboxes)
            .some((x) => x.checked);
        var updateButton = document.getElementById("btnUpdateStatus");
        if (updateButton) {
            updateButton.disabled = !isChecked;
        }
    }
}
