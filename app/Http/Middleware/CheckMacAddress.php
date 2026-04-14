<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CheckMacAddress
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
      

        // $allowedMacAddress = env('ALLOWED_MAC_ADDRESS'); // Get the allowed MAC address from your .env file
        // $clientMacAddress = $this->getClientMacAddress($request);

        // $clientSerialNumber = $this->getClientSerialNumber($request);
        // $allowedSerialNumber = env('ALL_EEE'); 

        // $clientBaseNumber = $this->getBaseboardSerialNumber($request);
        // $allowedBaseNumber = env('ALL_Base'); 

        // if ($clientMacAddress !== $allowedMacAddress || $clientSerialNumber !== $allowedSerialNumber || $clientBaseNumber !== $allowedBaseNumber) {
        //     // MAC address doesn't match, return unauthorized response or redirect
        //     // return response()->json(['error' => 'Unauthorized'], 401);
        //     abort(401);
        // }
        
        return $next($request);
    
    }

    // private function getClientMacAddress($request)
    // {
    //     // Use `ifconfig` or `ip` command to get network information
    //     $output = shell_exec('ip addr show');
    //     $macAddress = null;

    //     // Regular expression to find the MAC address in the output
    //     if (preg_match('/ether ([0-9a-fA-F:]{17})/', $output, $matches)) {
    //         $macAddress = $matches[1];
    //     }
    //     // dd($macAddress);
    //     return $macAddress;
    // }

    // private function getClientSerialNumber($request)
    // {
    //     // Use the Linux command to get the system's serial number
    //     $serialNumber = trim(shell_exec('sudo dmidecode -s system-serial-number 2>/dev/null'));
    
    //     // Check if the serial number was retrieved successfully
    //     if (empty($serialNumber)) {
    //         $serialNumber = 'Serial number not available';
    //     }
    // // dd($serialNumber);
    //     return $serialNumber;
    // }

    // public function getBaseboardSerialNumber($request)
    // {
    //     // Execute the shell command
    //     $serialNumber = shell_exec('sudo dmidecode -t baseboard | grep "Serial Number"');
        
    //     // Extract the serial number from the output (if needed)
    //     $serialNumber = trim(str_replace('Serial Number:', '', $serialNumber));
        
    //     // Log or return the result
    //     Log::info("Baseboard Serial Number: " . $serialNumber);
    //     // dd($serialNumber);
    //     return $serialNumber;
    // }
}
