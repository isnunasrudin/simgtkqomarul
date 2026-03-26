<!-- Sidebar -->
<div class="sidebar sidebar-style-2">
	<div class="sidebar-wrapper scrollbar scrollbar-inner">
		<div class="sidebar-content">
			{{-- <div class="user">
				<div class="avatar-sm float-left mr-2">
					<img src="{{ asset('img/profile.jpg') }}" alt="..." class="avatar-img rounded-circle">
				</div>
				<div class="info">
					<a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
						<span>
							{{ Auth::user()->name }}
							<span class="user-level">{{ Auth::user()->role == 'admin' ? 'Admin' : 'GTK' }}</span>
							<span class="caret"></span>
						</span>
					</a>
					<div class="clearfix"></div>

					<div class="collapse in" id="collapseExample">
						<ul class="nav">
							@if(Auth::user()->gtk)
							<li>
								<a href="{{ route('gtk.edit', Auth::user()->gtk->id) }}">
									<span class="link-collapse">Data GTK</span>
								</a>
							</li>
							@endif
							<!-- <li>
								<a href="#edit">
									<span class="link-collapse">Edit Profile</span>
								</a>
							</li> -->
							<li>
								<a href="{{ route('logout') }}">
									<span class="link-collapse">Keluar</span>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div> --}}
			<ul class="nav nav-primary">

				<li class="nav-item @active('/')">
					<a href="/">
						<i class="fas fa-home"></i>
						<p>Beranda</p>
					</a>
				</li>

				@cannot('admin')
				@if(Auth::user()->gtk)
				<li class="nav-item @active('gtk*')">
					<a href="{{ route('gtk.edit', Auth::user()->gtk->id) }}">
						<i class="fas fa-user"></i>
						<p>Data Saya</p>
					</a>
				</li>
				@endif
				@endcannot

				@can('admin')
				<li class="nav-section">
					<span class="sidebar-mini-icon">
						<i class="fa fa-ellipsis-h"></i>
					</span>
					<h4 class="text-section">Master</h4>
				</li>
				<li class="nav-item @active('ref*', 'active submenu') ">
					<a data-toggle="collapse" href="#referensi" class="collapsed" aria-expanded="false">
						<i class="fas fa-database"></i>
						<p>Referensi</p>
						<span class="caret"></span>
					</a>
					<div class="collapse @active('ref*', 'show')" id="referensi">
						<ul class="nav nav-collapse">
							<li>
								<a href="{{ route('ref.instansi.index') }}">
									<span class="sub-item">Satuan Kerja</span>
								</a>
							</li>
							<li>
								<a href="{{ route('ref.tugas_tambahan.index') }}">
									<span class="sub-item">Tugas Non Guru</span>
								</a>
							</li>
						</ul>
					</div>
				</li>
				<li class="nav-item @active('gtk*')">
					<a href="{{ route('gtk.index') }}">
						<i class="fas fa-user-tie"></i>
						<p>Data GTK</p>
					</a>
				</li>
				<li class="nav-item @active('contracts*')">
					<a href="{{ route('contracts.index') }}">
						<i class="fas fa-file-invoice"></i>
						<p>SK</p>
					</a>
				</li>

				<li class="nav-section">
					<span class="sidebar-mini-icon">
						<i class="fa fa-ellipsis-h"></i>
					</span>
					<h4 class="text-section">Administrator</h4>
				</li>
				<li class="nav-item @active('users*')">
					<a href="{{ route('users.index') }}">
						<i class="fas fa-users"></i>
						<p>Kredensial</p>
					</a>
				</li>
				@endcan
			</ul>
		</div>
	</div>
</div>