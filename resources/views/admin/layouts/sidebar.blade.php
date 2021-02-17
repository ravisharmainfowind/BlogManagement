<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">MAIN NAVIGATION</li>

      @if(auth('web')->user()->role_id==1)
     
      <li>
        <a href="{{ url('admin/users') }}">
         <i class="fa fa-users" aria-hidden="true"></i>
          <span>Users</span>
        </a>
      </li>

      <li>
        <a href="{{ url('admin/categories') }}">
         <i class="fa fa-home" aria-hidden="true"></i>
          <span>Category</span>
        </a>
      </li>

      <li>
        <a href="{{ url('admin/posts') }}">
         <i class="fa fa-home" aria-hidden="true"></i>
          <span>Posts</span>
        </a>
      </li>
      @endif

      @if(auth('web')->user()->role_id==2)
      <li>
        <a href="{{ url('admin/posts') }}">
         <i class="fa fa-home" aria-hidden="true"></i>
          <span>Posts</span>
        </a>
      </li>
      @endif
      
  </ul>
  </section>
  <!-- /.sidebar -->
</aside>