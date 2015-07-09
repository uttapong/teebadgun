<div class="col-md-12 center stat-block">
	
	<div id="stat-value-block" class="shadow" style="height: 250px !important;">
		<div class="stat-row"><a href="{{route('forums')}}"><span class="stat-label forums-stat">กระทู้ทั้งหมด</span><span class="stat-value label label-info">{{$all_cat_count}}</span></a></div>
		<div class="stat-row"><a href="{{route('category',array(3,'เรื่องทั่วไป'))}}"><span class="stat-label forums-stat">เรื่องทั่วไป</span><span class="stat-value label label-info">{{$general_cat_count}}</span></a></div>
		<div class="stat-row"><a href="{{route('category',array(4,'อุปกรณ์แบดมินตัน'))}}"><span class="stat-label forums-stat">อุปกรณ์แบดมินตัน</span><span class="stat-value label label-info">{{$review_cat_count}}</span></a></div>
		<div class="stat-row"><a href="{{route('category',array(6,'ตลาดซื้อขาย'))}}"><span class="stat-label forums-stat">ตลาดซื้อขาย</span><span class="stat-value label label-info">{{$market_cat_count}}</span></a></div>
		<div class="stat-row"><a href="{{route('category',array(5,'ประกาศ/แจ้งปัญหา'))}}"><span class="stat-label forums-stat">ประกาศ/แจ้งปัญหา</span><span class="stat-value label label-info">{{$support_cat_count}}</span></a></div>
		
	</div>
</div>