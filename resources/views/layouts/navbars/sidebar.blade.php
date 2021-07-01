<div class="sidebar" data-color="purple" data-background-color="white" data-image="{{ asset('material') }}/img/sidebar-1.jpg">
  <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
  <div class="logo">
    <a href="{{ url('/home') }}" class="simple-text logo-normal">
      {{ __('Admin Panel') }}
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
      <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('home') }}">
          <i class="material-icons">dashboard</i>
            <p>{{ __('Dashboard') }}</p>
        </a>
      </li>
      @if (auth()->user()->is_admin == 1)
      <li class="nav-item {{ ($activePage == 'pengajuan') ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#pengajuan" aria-expanded="true">
          <i><img style="width:25px" src="{{ asset('material') }}/img/icons8-external-link.svg"></i>
          <p>{{ __('Pengajuan') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse" id="pengajuan">
          <ul class="nav">
            <li class="nav-item{{ ($activePage == 'pengajuan-lembur') ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('pengajuan_lembur.index') }}">
                <i class="material-icons">article</i>
                <p>{{ __('Pengajuan Lembur') }}</p>
              </a>
            </li>
            <li class="nav-item{{ ($activePage == 'pengajuan-cuti') ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('pengajuan_cuti.index') }}">
                <i class="material-icons">speaker_notes</i>
                <p>{{ __('Pengajuan Cuti') }}</p>
              </a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item {{ ($activePage == 'riwayat') ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#riwayat" aria-expanded="true">
          <i><img style="width:25px" src="{{ asset('material') }}/img/icons8-bookmark.svg"></i>
          <p>{{ __('Riwayat') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse" id="riwayat">
          <ul class="nav">
            <li class="nav-item{{ ($activePage == 'riwayat-lembur') ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('riwayat_lembur.index') }}">
                <i class="material-icons">article</i>
                <p>{{ __('Riwayat Lembur') }}</p>
              </a>
            </li>
            <li class="nav-item{{ ($activePage == 'riwayat-cuti') ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('riwayat_cuti.index') }}">
                <i class="material-icons">speaker_notes</i>
                <p>{{ __('Riwayat Cuti') }}</p>
              </a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item {{ ($activePage == 'master') ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#laravelExample" aria-expanded="true">
          <i><img style="width:25px" src="{{ asset('material') }}/img/icons8-list-64.png"></i>
          <p>{{ __('Master') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse" id="laravelExample">
          <ul class="nav">
            <li class="nav-item{{ $activePage == 'profile' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('profile.edit') }}">
                <i class="material-icons">account_circle</i>
                <p>{{ __('User profile') }} </p>
              </a>
            </li>
            {{-- <li class="nav-item{{ $activePage == 'user-management' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('user.index') }}">
                <span class="sidebar-mini"> UM </span>
                <span class="sidebar-normal"> {{ __('User Management') }} </span>
              </a>
            </li> --}}
            <li class="nav-item{{ $activePage == 'pegawai' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('pegawai.index') }}">
                <i class="material-icons">how_to_reg</i>
                <p>{{ __('Pegawai') }}</p>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'register-user' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('user.index') }}">
                <i class="material-icons">assignment_ind</i>
                <p>{{ __('Register User') }}</p>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'pendidikan' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('pendidikan.index') }}">
                <i class="material-icons">school</i>
                <p>{{ __('Pendidikan') }}</p>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'jurusan' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('jurusan.index') }}">
                <i class="material-icons">precision_manufacturing</i>
                <p>{{ __('Jurusan') }}</p>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'jabatan' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('jabatan.index') }}">
                <i class="material-icons">recycling</i>
                <p>{{ __('Jabatan') }}</p>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'unit-kerja' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('unit_kerja.index') }}">
                <i class="material-icons">maps_home_work</i>
                <p>{{ __('Unit Kerja') }}</p>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'penempatan' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('penempatan.index') }}">
                <i class="material-icons">location_city</i>
                <p>{{ __('Penempatan') }}</p>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'jenis-cuti' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('jenis_cuti.index') }}">
                <i class="material-icons">fullscreen_exit</i>
                <p>{{ __('Jenis Cuti') }}</p>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'jenis-cuti-extra' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('jenis_cuti_extra.index') }}">
                <i class="material-icons">fullscreen</i>
                <p>{{ __('Jenis Cuti Extra') }}</p>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'maksimum-cuti' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('maksimum_cuti.index') }}">
                <i class="material-icons">apps_outage</i>
                <p>{{ __('Maksimum Cuti') }}</p>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'bank-legacy' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('bank_legacy.index') }}">
                <i class="material-icons">comment_bank</i>
                <p>{{ __('Bank Legacy') }}</p>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'rencana-cuti' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('rencana_cuti.index') }}">
                <i class="material-icons">tab</i>
                <p>{{ __('Rencana Cuti') }}</p>
              </a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item{{ $activePage == 'laporan' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('laporan.index') }}">
          <i class="material-icons">analytics</i>
            <p>{{ __('Laporan') }}</p>
        </a>
      </li>
      @elseif (auth()->user()->is_admin == 2)
      <li class="nav-item{{ $activePage == 'laporan' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('laporan.index') }}">
          <i class="material-icons">analytics</i>
            <p>{{ __('Laporan') }}</p>
        </a>
      </li>
      @else
      <li class="nav-item{{ ($activePage == 'pengajuan-lembur') ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('pengajuan_lembur.index') }}">
          <i class="material-icons">article</i>
          <p>{{ __('Perintah Lembur') }}</p>
        </a>
      </li>
      <li class="nav-item{{ ($activePage == 'pengajuan-cuti') ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('pengajuan_cuti.index') }}">
          <i class="material-icons">speaker_notes</i>
          <p>{{ __('Pengajuan Cuti') }}</p>
        </a>
      </li>
      <li class="nav-item {{ ($activePage == 'riwayat') ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#riwayat" aria-expanded="true">
          <i><img style="width:25px" src="{{ asset('material') }}/img/icons8-bookmark.svg"></i>
          <p>{{ __('Riwayat') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse" id="riwayat">
          <ul class="nav">
            <li class="nav-item{{ ($activePage == 'riwayat-lembur') ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('riwayat_lembur.index') }}">
                <i class="material-icons">article</i>
                <p>{{ __('Riwayat Lembur') }}</p>
              </a>
            </li>
            <li class="nav-item{{ ($activePage == 'riwayat-cuti') ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('riwayat_cuti.index') }}">
                <i class="material-icons">speaker_notes</i>
                <p>{{ __('Riwayat Cuti') }}</p>
              </a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item {{ ($activePage == 'master') ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#laravelExample" aria-expanded="true">
          <i><img style="width:25px" src="{{ asset('material') }}/img/icons8-list-64.png"></i>
          <p>{{ __('Master') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse show" id="laravelExample">
          <ul class="nav">
            {{-- <li class="nav-item{{ $activePage == 'profile' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('profile.edit') }}">
                <i class="material-icons">account_circle</i>
                <p>{{ __('User profile') }} </p>
              </a>
            </li> --}}
            {{-- <li class="nav-item{{ $activePage == 'user-management' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('user.index') }}">
                <span class="sidebar-mini"> UM </span>
                <span class="sidebar-normal"> {{ __('User Management') }} </span>
              </a>
            </li> --}}
            <li class="nav-item{{ $activePage == 'pegawai' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('pegawai.index') }}">
                <i class="material-icons">how_to_reg</i>
                <p>{{ __('Pegawai') }}</p>
              </a>
            </li>
          </ul>
        </div>
      </li>
      @endif
    </ul>
  </div>
</div>
