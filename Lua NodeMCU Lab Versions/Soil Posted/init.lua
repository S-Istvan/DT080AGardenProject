wifi.setmode(wifi.STATION)
station_cfg={}
station_cfg.ssid="VM5614E97"
station_cfg.pwd="ua86ybhyZXhy"
wifi.sta.config(station_cfg)
wifi.sta.connect()
print("Client IP Address:",wifi.sta.getip())
print("Looking for a connection")
counter=0
tmr.alarm(1, 10000, 1, function()
    --sntp.sync("clock.via.net",
      --function(sec, usec, server, info)
        --print('sync', sec, usec, server)
        --testtm = rtctime.epoch2cal(rtctime.get())
        counter=counter+1 
        --print(string.format("%04d/%02d/%02d %02d:%02d:%02d", testtm["year"], testtm["mon"], testtm["day"], testtm["hour"], testtm["min"], testtm["sec"]))
      --end,
      --function()
         --print('failed!')
      --end,
      --0
    --)   
    --print(rtctime.get())
    if(wifi.sta.getip()~=nil and counter ~= 0 ) then
        tmr.stop(1)
        tmr.unregister(1)
        print("Connected!")
        print("Client IP Address:",wifi.sta.getip())
        dofile("clientSendSoilData.lua")
    end
end)
