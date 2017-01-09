<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <ul class="sidebar-menu">
      <li class="treeview{{ ($menu == 'receipt') ? ' active' : '' }}">
        <a href="/admin/lancamentos/receitas">
          <i class="fa fa-money"></i><span>Receitas</span></a>
      </li>
      <li class="treeview{{ ($menu == 'expense') ? ' active' : '' }}">
        <a href="/admin/lancamentos/despesas">
          <i class="fa fa-university"></i><span>Despesas</span></a>
      </li>
      <li class="treeview{{ ($menu == 'balance') ? ' active' : '' }}">
        <a href="/admin/lancamentos/balanco">
          <i class="fa fa-bar-chart"></i><span>Balanço</span></a>
      </li>
      <li class="treeview{{ ($menu == 'account') ? ' active' : '' }}">
        <a href="/admin/contas">
          <i class="fa fa-bookmark"></i><span>Contas</span></a>
      </li>
      <li class="treeview{{ ($menu == 'category') ? ' active' : '' }}">
        <a href="/admin/config/categorias">
          <i class="fa fa-th-large"></i><span>Categorias</span></a>
      </li>
      <li class="treeview{{ ($menu == 'user') ? ' active' : '' }}">
        <a href="/admin/usuario">
          <i class="fa fa-user"></i><span>Usuários</span></a>
      </li>
    </ul>
  </section>
</aside>