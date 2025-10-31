<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <p>Welcome, {{ Auth::user()->name }}!</p>
                <p>User Roles: {{ Auth::user()->getRoleNames() }}</p>
                <p>User Permissions: {{ Auth::user()->getAllPermissions()->pluck('name') }}</p>

                @role('admin')
                <div class="mt-4 p-4 bg-blue-100 rounded">
                    <p>Admin Panel Access Granted ✅</p>
                    <button class="bg-blue-500 text-white px-4 py-2 rounded">Manage Users</button>
                </div>
                @endrole

                @role('tradesperson')
                <div class="mt-4 p-4 bg-green-100 rounded">
                    <p>Tradesperson Dashboard</p>
                </div>
                @endrole

                @role('homeowner')
                <div class="mt-4 p-4 bg-yellow-100 rounded">
                    <p>Homeowner Dashboard</p>
                </div>
                @endrole

                @can('create job')
                    <button class="mt-4 bg-green-500 text-white px-4 py-2 rounded">Create Job</button>
                @endcan

            </div>
        </div>
    </div>
</x-app-layout>
