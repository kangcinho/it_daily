<nav class="sidebar bg-dark">
    <ul class="list-unstyled">
      <li>
        <a href="#master" data-toggle="collapse" aria-expanded="false"><i class="fab fa-bitbucket"></i> Master Data</a>
        <ul class="collapse list-unstyled" id="master">
          <li class={!! (url('unit')==url()->current())?"active":"" !!}><a href="{!! url('unit') !!}" ><i class="fa fa-address-book"></i> Data Unit</a></li>
        </ul>
      </li>
      <li class={!! (url('itdaily')==url()->current())?"active":"" !!}><a href="{!! url('itdaily') !!}" ><i class="fa fa-history"></i> Job IT</a></li>
    </ul>
</nav>
