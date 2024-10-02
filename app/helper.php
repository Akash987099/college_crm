<?php
use App\Models\Privilege;
use App\Models\Program;
use App\Models\HistoryReport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// echo "hello";

// Assuming you have a function named ViewPermission
// Helper function in a helper file or somewhere included in your application



function ViewPermission($programId)
{
    $userid = Auth::user()->id;

    $privilege = Privilege::where('program_id', $programId)
                         ->where('user_id', $userid)
                         ->first();

    if ($privilege != null && $privilege != "") {
        if ($privilege->view_priv == 1) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function AddPermission($programId){

    $userid = Auth::user()->id;

    $privilege = Privilege::where('program_id', $programId)
                         ->where('user_id', $userid)
                         ->first();

    if ($privilege != null && $privilege != "") {
        if ($privilege->add_priv == 1) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }

}

function EditPermission($programId){

    $userid = Auth::user()->id;

    $privilege = Privilege::where('program_id', $programId)
                         ->where('user_id', $userid)
                         ->first();

    if ($privilege != null && $privilege != "") {
        if ($privilege->modify_priv == 1) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
    
}

function DeletePermission($programId){
    $userid = Auth::user()->id;

    $privilege = Privilege::where('program_id', $programId)
                         ->where('user_id', $userid)
                         ->first();

    if ($privilege != null && $privilege != "") {
        if ($privilege->del_priv == 1) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
   
}
