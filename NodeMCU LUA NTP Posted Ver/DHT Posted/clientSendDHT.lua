wifi.sta.autoconnect(1)
pin = 2
status, temp, humi = dht.read(pin)
if(wifi.sta.getip()~=nil) then
    if(testtm["year"] ~= 1970) then 
        curMins = 60 - testtm["min"]
        curSecs =  testtm["sec"]
        convMins = curMins*60*1000000
        convSecs = curSecs*1000000
        convTime = (convMins-convSecs)
        http.post('http://192.168.0.221/garden/airData.php',
            'Content-Type: application/x-www-form-urlencoded\r\n',
            'airTemp='..temp..'&'..'airHumi='..humi,
            function(code, data)
                if(code < 0) then
                    print("Request Failed")
                else
                    print(code, data)
                    print("Got Disconnection")
                    rtctime.dsleep(convTime,1)
                end 
         end)
    end
else
    print("Error: Not connected to wifi")
    dofile("init.lua")
end
