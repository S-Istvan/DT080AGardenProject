wifi.sta.autoconnect(1)
ltable = {}
ltable.id = 0
ltable.sda = 6
ltable.scl = 5
tmr.alarm(2,5000,1,function()
      --we only want to run this function once, so after the timer
      --calls the function then stop and unregister the alarm
      tmr.stop(2)
      tmr.unregister(2)
      --run the function that will read the data from the sensor
      findByte = readBH1750( 0x23, 0x10)
      --convert the two bytes into a decimal number
      lux = findByte:byte(1) * 256 + findByte:byte(2)
      --The datasheet mentions that we need to divide the answer by 1.2
      --we are using the integer firmware so to divide by 1.2
      --we first multiply by 1000 and then divide by 1200
      lux = (lux*1000)/1200
      --these prints are just for testing purposes remove from the final project
      print("BH1750 reads: ")
      print(lux)
      print(" lux")
      --run the function that will send the data to the webserver
      sendData()
end)
--This function will send the command to BH1750 and return the lux value
function readBH1750(bhAdd, command)
      --I already stopped the timer, test and remove this line
      tmr.stop(2)
      --communicate with the sensor using the i2c library
      --first setup the i2c communication with address(0) sda line and scl line
      i2c.setup(ltable.id,ltable.sda,ltable.scl, i2c.SLOW)
      i2c.start(ltable.id)
      --set up the i2c for writing - first 7 bits is the device address and 1 bit for direction(write)
      i2c.address(ltable.id,0x23,i2c.TRANSMITTER)
      --write the command to the i2c bus
      i2c.write(ltable.id, 0x20)
      i2c.stop(ltable.id)
      i2c.start(ltable.id)
      --now set the i2c to read - first 7 bits is the device address and 1 bit for direction(read)
      i2c.address(ltable.id,0x23,i2c.RECEIVER)
      --delay for 200ms to allow device to operate - mentioned in the datasheet to wait for 180ms at least
      tmr.delay(200000)
      --read the response from the module and store it in a variable
      bhResponse = i2c.read(ltable.id,2)
      i2c.stop(ltable.id)
      return bhResponse
end
--this function will send the data to the webserver
function sendData()   
      if(wifi.sta.getip()~=nil) then
           if(testtm["year"] ~= 1970) then 
                  --these print statement are just for teting purposes - remove from final project
                  --print("Minutes: ")
                  --print(testtm["min"])
                  --print("Seconds: ")
                  --print(testtm["sec"])
                  --these next lines will determine how many microseconds are left until the next hour
                  --for example - the time is 20:35:47 - time to 21:00:00 is 24 minutes 13 seconds
                  --we first get the minutes to the next hour by taking the testtm["min"] from 60
                  --in our example this gives 60 - 35 = 25 minutes
                    curMins = 60 - testtm["min"]
                  --then we get the seconds
                    curSecs = testtm["sec"]
                  --then we convert the minutes to microseconds
                    convMins = curMins*60*1000000
                  --and the seconds to microseconds
                    convSecs = curSecs*1000000
                  --last we take the seconds away from the minutes 
                  --answer in minutes would be 25 minutes - 47 seconds = 24 minutes 13 seconds
                    convTime = (convMins-convSecs)
                  http.post('http://192.168.0.221/garden/luxData.php',
                  'Content-Type: application/x-www-form-urlencoded\r\n',
                  'lux='..lux,
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

end
