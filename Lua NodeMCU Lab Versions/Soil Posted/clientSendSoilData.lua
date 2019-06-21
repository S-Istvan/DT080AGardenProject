wifi.sta.autoconnect(1)
soilHumi = adc.read(0)
print(soilHumi)
if(wifi.sta.getip()~=nil) then
    --if(testtm["year"] ~= 1970) then
        --curMins = 60 - testtm["min"]
        --curSecs =  testtm["sec"]
        --convMins = curMins*60*1000000
        --convSecs = curSecs*1000000
        --convTime = (convMins-convSecs)
        --print("time =")
        --print(convTime)
        http.post('http://192.168.0.221/garden/soilData.php',
            'Content-Type: application/x-www-form-urlencoded\r\n',
            'soilHumi='..soilHumi,
            function(code, data)
                if(code < 0) then
                    print("Request Failed")
                else
                    print(code, data)
                    print("Got Disconnection")
                    rtctime.dsleep(30000000,1)
                end 
        end)
    --end
else
    print("Error: Not connected")
    dofile("init.lua")
end
