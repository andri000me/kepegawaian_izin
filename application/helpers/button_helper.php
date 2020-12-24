<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

function btn_import($method, $btn_name)
{ ?>
    <button class="btn btn-xs purple" onclick="<?php $method ?>">
        <i class="fa fa-upload"></i><?php $btn_name ?>
    </button>
<?php } ?>
<?php
function get_btn_group1($btn_edit, $btn_delete)
{
    $li_btn_edit    = '<button class="badge bg-green" title="Edit Data" onClick=' . $btn_edit . '><li style="font-size:10px" class="fa fa-pencil"></li></button>';
    $li_btn_delete  = '<button class="badge bg-red" title="Hapus Data" onClick=' . $btn_delete . '><li style="font-size:10px" class="fa fa-trash"></li></button>';
    return '<div class="text-center">' . $li_btn_edit . $li_btn_delete . '</div>';
}

function btn_upload_gambar($upload)
{
    $btn_upload = '<button class="badge bg-blue" onClick=' . $upload . ' title="Update/Upload Gambar"><li style="font-size:12px" class="fa fa-upload"></li></button>';
    return '<div class="text-center">' . $btn_upload . '</div>';
}

function get_btn_export($btn_edit)
{
    $li_btn_edit    = '<button class="btn btn-sm btn-info" title="Cetak Slip Gaji" onClick=' . $btn_edit . '><li class="fa fa-print"></li></button>';
    return '<div class="text-center">' . $li_btn_edit . '</div>';
}

function get_btn_verifikasi1($btn_edit, $btn_delete)
{
    $li_btn_edit    = '<button class="btn btn-sm btn-info" title="Terima Verifikasi" onClick=' . $btn_edit . '><li class="fa fa-check-square-o"></li> Verify </button>';
    $li_btn_delete  = '<button class="btn btn-sm btn-danger" title="Tolak Verifikasi" onClick=' . $btn_delete . '><li class="fa fa-ban"></li> Unverify </button>';
    return '<div class="text-center">' . $li_btn_edit . $li_btn_delete . '</div>';
}

function get_btn_verifikasi($btn_edit, $btn_delete)
{
    $li_btn_edit    = '<button class="btn btn-sm btn-info" title="Terima Verifikasi" onClick=' . $btn_edit . '><li class="fa fa-check-square-o"></li> Edit </button>';
    $li_btn_delete  = '<button class="btn btn-sm btn-danger" title="Tolak Verifikasi" onClick=' . $btn_delete . '><li class="fa fa-ban"></li> Hapus </button>';
    return '<div class="text-center">' . $li_btn_edit . $li_btn_delete . '</div>';
}
function get_btn_group_user($btn_changepwd, $btn_edit, $btn_delete)
{
    $li_btn_change    = '<button class="btn btn-xs green-haze" title="Edit Data" onClick=' . $btn_changepwd . '><li class="fa fa-key"></li></button>';
    $li_btn_edit    = '<button class="btn btn-xs blue" title="Edit Data" onClick=' . $btn_edit . '><li class="fa fa-pencil"></li></button>';
    $li_btn_delete  =  '<button class="btn btn-xs red" title="Hapus Data" onClick=' . $btn_delete . '><li class="fa fa-trash"></li></button>';
    return '<div class="text-center">' . $li_btn_change . $li_btn_edit . $li_btn_delete . '</div>';
}

function get_add_btn($action)
{
    # code...
    $btn_add = '<button class="btn btn-xs blue btn-circle" onclick=' . $action . '><i class="fa fa-plus"></i>Tambah Data Kerja Sama</button>';
    return $btn_add;
}

function btn_perpanjang_mitra($action)
{
    # code...
    $btn    = '<button style="font-size:10px;" class="btn btn-xs green" title="Ubah masa berakhir" onClick=' . $action . '><li class="fa fa-pencil"></li> Edit Masa Berakhir</button>';
    return $btn;
}

function get_btn_edit($btn_edit)
{
    $li_btn_edit    = '<button class="btn btn-xs blue" title="Edit Data" onClick=' . $btn_edit . '><li class="fa fa-pencil"></li></button>';
    return '<div class="text-center">' . $li_btn_edit . '</div>';
}
function get_btn_delete($btn_delete)
{
    $li_btn_delete  = '<button class="btn btn-sm btn-danger" title="Hapus Data" onClick=' . $btn_delete . '><li class="fa fa-trash"></li></button>';
    return '<div class="text-center">' . $li_btn_delete . '</div>';
}

function get_btn_group_delete_disable($btn_edit, $btn_delete)
{
    $li_btn_edit    = '<button class="btn btn-xs blue" title="Edit Data" onClick=' . $btn_edit . '><li class="fa fa-pencil"></li></button>';
    $li_btn_delete  = '<button class="btn btn-xs red" title="Hapus Data" onClick=' . $btn_delete . ' disabled><li class="fa fa-trash"></li></button>';
    return '<div class="text-center">' . $li_btn_edit . $li_btn_delete . '</div>';
}

function get_btn_group($btn_detail, $btn_edit, $btn_delete)
{
    $li_btn_detail  = '<button class="btn btn-xs yellow" title="Lihat Detail" onClick=' . $btn_detail . '><li class="fa fa-search"></li> </button>';
    $li_btn_edit    = '<button class="btn btn-xs blue" title="Edit Data" onClick=' . $btn_edit . '><li class="fa fa-pencil"></li></button>';
    $li_btn_delete  = '<button class="btn btn-xs red" title="Hapus Data" onClick=' . $btn_delete . '><li class="fa fa-trash"></li></button>';
    return '<div class="text-center">' . $li_btn_detail . $li_btn_edit . $li_btn_delete . '</div>';
}

function block_unblock()
{
    # code...
    $block = '<div class="btn btn-xs btn-danger">Block</div>';
    $unblock = '<div class="btn btn-xs btn-info">Unblock</div>';

    return '<div class="text-center">' . $block . '' . $unblock . '</div>';
}

function _btn_Action_($action_add, $action_import, $action_report)
{
    # code...
    $btn_add    = '<button class="btn btn-xs blue" style="font-size:10px;" onclick="' . $action_add . '" title="Click here to Add new Data"><i class="fa fa-floppy-o"></i>Tambah</button>';
    $btn_import = '<button class="btn btn-xs red" onclick="' . $action_import . '" style="font-size:10px;" title="Click here to Import excel file !"><i class="fa fa-upload"></i>Import</button>';
    $btn_report = '<button class="btn btn-xs green-jungle" onclick="' . $action_report . '" style="font-size:10px;" ><i class="fa fa-file"></i>Report</button>';
    return $btn_add . $btn_import . $btn_report;
}
