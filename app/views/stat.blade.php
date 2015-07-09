<div class="col-md-12 center stat-block">
	<div id="sign" ><span class="glyphicon glyphicon-stats"></span> สถิติ</div>
	<div id="stat-value-block" class="shadow">
		<div class="stat-row"><span class="stat-label">จำนวนคอร์ททั้งหมด</span><span class="stat-value label label-info">{{$stat_all_court}}</span></div>
		<div class="stat-row"><span class="stat-label">ทีมเปิดทำการ</span><span class="stat-value  label label-info">{{$stat_open_team}}</span></div>
		<div class="stat-row"><a href="{{route('announcement')}}">การแข่งขันในช่วงนี้<span class="stat-label"></span><span class="stat-value label label-info">{{$stat_all_announcement}}</span></a></div>
		<div class="stat-row"><span class="stat-label">สมาชิกออนไลน์</span><span class="stat-value label label-warning">{{$stat_all_member}}</span></div>
	</div>
</div>