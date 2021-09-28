<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="#" class="brand-link">
    <img src="{{url('dist/img/synq.png')}}" alt="Synq Logo" class="brand-image img-circle elevation-3"
         style="opacity: .8">
    <span class="brand-text font-weight-light">Synq Africa</span>
  </a>


  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="pb-3 mt-3 mb-3 user-panel d-flex">
      <div class="image">
        <img src="{{url('dist/img/missing.jpg')}}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">{{ Auth::user()->getRoleNames()->first() }}/{{ Auth::user()->username }}</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <a href="{{route('balances.create')}}" class="nav-link active">
         <i class="nav-icon fas fa-university"></i>
         <p>
           Wallet
         </p>
       </a>
       <a href="{{route('home')}}" class="nav-link active">
         <i class="nav-icon fas fa-tachometer-alt"></i>
         <p>
           Dashboard
         </p>
       </a>
       <a href="{{route('tabM_1')}}" class="nav-link active">
         <i class="fa fa-send"></i>
         <p>
           Quick SMS
         </p>
       </a>
       <a href="{{route('messages.index')}}" class="nav-link">
         <i class="fa fa-podcast" aria-hidden="true"></i>
         <p>Sent Messages</p>
       </a>
          <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                  <i class="fa fa-podcast" aria-hidden="true"></i>
                  <p>
                      Received Messages
                      <i class="fas fa-angle-left right"></i>
                  </p>
              </a>
              <ul class="nav nav-treeview">
                  <li class="nav-item">
                      <a href="{{route('received.index')}}" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Incoming Messages</p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{route('inbox')}}" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Chat Area</p>
                      </a>
                  </li>
              </ul>
          </li>
       <a href="{{route('schedules.index')}}" class="nav-link">
         <i class="fa fa-clock-o" aria-hidden="true"></i>
         <p>Scheduled Messages</p>
       </a>
       <li class="nav-item has-treeview">
         <a href="#" class="nav-link">
           <i class="fa fa-bullhorn" aria-hidden="true"></i>
           <p>
             Manage Campaigns
             <i class="fas fa-angle-left right"></i>
           </p>
         </a>
         <ul class="nav nav-treeview">
           <li class="nav-item">
             <a href="{{route('tabG_1')}}" class="nav-link">
               <i class="far fa-circle nav-icon"></i>
               <p>New Campaign</p>
             </a>
           </li>
           <li class="nav-item">
             <a href="{{route('templates.index')}}" class="nav-link">
               <i class="far fa-circle nav-icon"></i>
               <p>Message Templates</p>
             </a>
           </li>
           <li class="nav-item">
             <a href="{{route('groups.index')}}" class="nav-link">
               <i class="far fa-circle nav-icon"></i>
               <p>Contacts Groups</p>
             </a>
           </li>
         </ul>
       </li>
       <li class="nav-item has-treeview">
         <a href="#" class="nav-link">
           <i class="fa fa-address-book" aria-hidden="true"></i>
           <p>
             Manage Contacts
             <i class="fas fa-angle-left right"></i>
           </p>
         </a>
         <ul class="nav nav-treeview">
           <li class="nav-item">
             <a href="{{route('import')}}" class="nav-link">
               <i class="far fa-circle nav-icon"></i>
               <p>Import Contacts</p>
             </a>
           </li>
           <li class="nav-item">
             <a href="{{route('contacts.index')}}" class="nav-link">
               <i class="far fa-circle nav-icon"></i>
               <p>Contacts</p>
             </a>
           </li>
         </ul>
       </li>
       <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="fas fa-poll" aria-hidden="true"></i>
          <p>
            Surveys
            <i class="fas fa-angle-left right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{route('survey.index')}}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>all</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p><i class="fa fa-plus"></i> New</p>
            </a>
          </li>
        </ul>
      </li>
       <li class="nav-item has-treeview">
         <a href="#" class="nav-link">
           <i class="fa fa-handshake-o" aria-hidden="true"></i>
           <p>
             M-Pesa
             <i class="fas fa-angle-left right"></i>
           </p>
         </a>
         <ul class="nav nav-treeview">
           <li class="nav-item">
             <a href="{{route('mpesa_codes.index')}}" class="nav-link">
               <i class="far fa-circle nav-icon"></i>
               <p>Mpesa Codes</p>
             </a>
           </li>
           <li class="nav-item">
             <a href="{{route('transactions.index')}}" class="nav-link">
               <i class="far fa-circle nav-icon"></i>
               <p>M-Pesa Transactions</p>
             </a>
           </li>
           <li class="nav-item">
             <a href="{{route('notfis.index')}}" class="nav-link">
               <i class="far fa-circle nav-icon"></i>
               <p>Auto-Notify Message</p>
             </a>
           </li>
         </ul>
       </li>
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="fa fa-cogs" aria-hidden="true"></i>
            <p>
              Settings
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ url('users/show_user') }}/{{ id(Auth::user()->id) }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>My Profile</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('users/show_client') }}/{{ id(Auth::user()->client_id) }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Account Settings</p>
              </a>
            </li>
          </ul>
        </li>
        @role('super-admin|admin|manager')
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="fa fa-users" aria-hidden="true"></i>
            <p>
              Clients
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{route('clients.index')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>clients</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('users.index')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Users</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('invites.index')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Invites</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('route_maps.index')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Assigned Routes</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('tab_1')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Add Client</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('invite_view')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Add User</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('route_maps.create')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Assign Route to Client</p>
              </a>
            </li>
          </ul>
        </li>
        @endrole
        @role('super-admin|admin|manager')
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="fa fa-credit-card" aria-hidden="true"></i>
            <p>
              Credit Allocations
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{route('clients_credits')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Credit Balances</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('allocations.index')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Credit Allocations</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('allocations.create')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>New Allocation</p>
              </a>
            </li>
          </ul>
        </li>
        @endrole
        @role('super-admin|admin|manager')
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="fa fa-wifi" aria-hidden="true"></i>
            <p>
              Networks
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{route('networks.index')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Available Networks</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('prefixes.index')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Network Prefixes</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('routes.index')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Kannel Routes</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('tabN_1')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Add New Network</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('prefixes.create')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Add Network Prefix</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('routes.create')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Add Kannel Route</p>
              </a>
            </li>
          </ul>
        </li>
        @endrole
        @role('super-admin|admin|manager')
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="fa fa-space-shuttle" aria-hidden="true"></i>
            <p>
              Short Codes
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{route('shortcodes.index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon" aria-hidden="true"></i>
                  <p>Shortcodes</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('shortcodes.create')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>New Shortcode</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('shortcode_prices.index')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Shortcode-Specific Prices</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="fa fa-space-shuttle" aria-hidden="true"></i>
            <p>
              Sender IDs
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{route('senders.index')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Senders</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('senders.create')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>New Sender ID</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('sender_prices.index')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>SenderId-Specific Prices</p>
              </a>
            </li>
          </ul>
        </li>
        @endrole
        @role('super-admin')
        <li class="nav-item">
          <a href="{{route('roles.index')}}" class="nav-link">
            <i class="fa fa-lock" aria-hidden="true"></i>
            <p>Roles</p>
          </a>
        </li>
        @endrole

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
