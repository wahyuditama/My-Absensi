<!-- untuk mengubah Status dengan function -->
<?php
function changeStatus($status)
{
    switch ((int)$status) {
        case 0:
            $badge =  '<span class="btn-sm btn bg-success text-white bg-warning">Pending</span>';
            break;

        case '1':
            $badge = "<span class='btn-sm btn bg-success text-white'> Disetujui</span>";
            break;

        case '2':
            $badge = "<span class='btn-sm btn bg-danger text-white'> Ditolak</span>";
            break;

        default:
            $badge = "<span class='badge bg-secondary'>Tidak Diketahui</span>";

            break;
    }
    return $badge;
}

function changeAbsen($status)
{
    switch ((int)$status) {
        case 0:
            $badge =  '<span class="btn-sm btn bg-success text-white bg-warning">Terlambat</span>';
            break;

        case '1':
            $badge = "<span class='btn-sm btn bg-success text-white'> Hadir</span>";
            break;

        case '2':
            $badge = "<span class='btn-sm btn bg-danger text-white'>Izin</span>";
            break;

        default:
            $badge = "<span class='badge bg-secondary'>Tidak Diketahui</span>";

            break;
    }
    return $badge;
}
