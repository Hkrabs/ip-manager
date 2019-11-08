
			<div class="col-md-9" id="page">
				<div id="content">
					<h3>Karalisteye Ekle</h3>
                                
                    <form action="add-to-blacklist.php?redirect=index.php" method="POST">
                        <div class="form-group">
                            <label for="ip_address">
                                IP Adresi:
                            </label>
                            <div>
                                <input type="text" name="ip_address" class="form-control" autofocus placeholder="1.1.1.1/24" id="ip_address" pattern="^([0-9]{1,3}\.){3}[0-9]{1,3}(\/([0-9]|[1-2][0-9]|3[0-2]))?$" title="0.0.0.0/0 - 255.255.255.255/32 veya 0.0.0.0 - 255.255.255.255" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ttl">
                                Son Dakikaları:
                            </label>
                            <div>
                                <input type="number" name="ttl" class="form-control" aria-describedby="ttlInfo" placeholder="5" id="ttl" />
                            </div>
                            <small id="ttlInfo" class="form-text text-muted">Girilmediği takdirde kayıt kendi kendine silinmez.</small>
                        </div>
                        <div class="form-group">
                            <label for="reason">
                                Sebep:
                            </label>
                            <div>
                                <input type="text" name="reason" class="form-control" placeholder="Spam" id="reason" />
                            </div>
                        </div>
                        <button type="submit" class="btn btn-danger">Kaydet</button>
                    </form>
				</div>
			</div>	
		</div>
	</div>