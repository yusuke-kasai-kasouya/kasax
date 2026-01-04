	<div id="laravel-info" style="color: #000000ff; text-align:center; padding:5px; font-size:12px;">
			Laravel通信中...
	</div>

	<script>
	// JavaScriptでLaravelからデータを取ってくる
	fetch('http://192.168.1.200:4001/laravel/public/kx-debug/wp-connect')
			.then(response => response.text())
			.then(data => {
					document.getElementById('laravel-info').innerText = data;
			})
			.catch(error => {
					document.getElementById('laravel-info').innerText = 'Laravelが起動していません';
			});
	</script>