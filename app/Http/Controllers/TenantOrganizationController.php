<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NeoOrganization;
use App\Models\NeoTenant;

class TenantOrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getOrganizations(NeoTenant $tenant)
    {
       /*  $organizations = $tenant->organizations()
        ->with('parent')
        ->orderBy('parent_id')
        ->orderBy('name_organization')
        ->get()
        ->groupBy('parent_id'); */
        $organizations = $tenant->organizations()
        //->where('type', 'Operacion') 
        ->whereIn('type', ['Operacion','Capacitacion']) // 🔍 Filtrar solo tipo operación
        ->with('parent')
        ->orderBy('parent_id')
        ->orderBy('name_organization')
        ->get()
        ->groupBy('parent_id');
        return response()->json($organizations);
    }
}
