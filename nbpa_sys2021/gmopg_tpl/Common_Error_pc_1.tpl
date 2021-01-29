<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="Content-style-Type" content="text/html; charset=UTF-8" />
	<title>Nature's Best Photography Asia</title>

	<link href="{$CSSPATH}/common.css" rel="stylesheet" type="text/css" />

	{literal}
	<script type="text/javascript">
		if( document.all ){
			window.document.onkeydown = function(){
				if( event.keyCode == 8 ){
					return false
				}
			}
		}else{
			window.onkeydown = function( event ){
				if( event.keyCode == 8 ){
					return false
				}
			}
		}
		var submitted = {
						0:false,
						1:false,
						2:false
					}
		function blockForm( number ){
			if( submitted[number] ){
				return false
			}
			submitted[number] = true
			return true
		}
	</script>
	{/literal}

</head>

<body>

<div class="wrapper">
<div class="bodyinner">

	<!--ヘッダー開始-->
	<div class="header">
		<h1>お支払手続き / Payment</h1>
	</div>

	<div class="main">

		<div class="block">
			<div class="bl_title">
				<div class="bl_title_inner">
					<h2>
						<span class="p">{$message.headline}</span>
					</h2>
				</div>
			</div>

			<div class="bl_body">

				<p id="GP_errMessage">
					{if $ErrorMessageArray neq null}
						<ul>
						{foreach item=message from=$ErrorMessageArray}
							<li>{$message}</li>
						{/foreach}
						</ul>
					{else}
						<ul>
							{if $message.retry ne null}
							<li>{$message.retry}</li>
							{/if}
							{if $message.cancel ne null}
							<li>{$message.cancel}</li>
							{/if}
						</ul>
					{/if}
				</p>
				<ul>
				{if $MailLinkOrderNo eq null}
					<li>
						<form action="{$RetURL|htmlspecialchars}" method="post" onsubmit="return blockForm(0)">
							<p id="fields">
								ショッピングサイトに戻る場合 / Back to shopping site &gt;
								{insert name=input_returnParams}
								<p class="control">
									<span class="control">
										<input type="submit" value="{$label.cancel}" />
									</span>
								</p>
							</p>
						</form>
						<br class="clear" />
					</li>
				{/if}
				{if $RetryURL neq null }
					<li>
						<form action="{$RetryURL|htmlspecialchars}" method="post" onsubmit="return blockForm(1)">
							<p>
								必要事項の記入からもう一度試してみる / Retry to fill payment form &gt;
								{insert name="input_keyItems"}
								<p class="control">
									<span class="control">
										<input type="submit" value="{$label.retry}" />
									</span>
								</p>
							</p>
						</form>
						<br class="clear" />
					</li>
				{/if}
				{if $SelectURL neq null }
					<li>
						<form action="{$SelectURL|htmlspecialchars}" method="post" onsubmit="return blockForm(2)">
							<p>
								違う決済方法を選択する / Choose an other payment &gt;
								{insert name="input_keyItems"}
								<p class="control">
									<span class="control">
										<input type="submit" value="{$label.select}" />
									</span>
								</p>
							</p>
						</form>
						<br class="clear" />
					</li>
				{/if}
				</ul>
			</div>
		</div>
	</div>
</div>
</div>
{* デバッグが必要な場合、以下の行の * を削除して、コメントを外してください。 *}
{*insert name="debug_showAllVars"*}
</body>
</html>