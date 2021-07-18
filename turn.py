text = str (input ("type a command"))

command = text.split()

print (command)

    #---------------------------ON------------------------------------------#

# if ("turn" in command or "switch" in command or "put" in command) and "on" in command and "washing" in command and "machine" in command:
#     print ("turning on your washing machine")
    

# if ("turn" in command or "switch" in command or "put" in command) and "on" in command and "dryer" in command:
#     print ("turning on your dryer")
#     address = fr"http://localhost/nlp?key=passkey&device=dryer&turn_on=1"
#     address = address.replace(' ', '%20')
#     web_res = requests.post(address).json()

# if ("turn" in command or "switch" in command or "put" in command) and "on" in command and "fridge" in command:
#     print ("turning on your fridge")

# if ("turn" in command or "switch" in command or "put" in command) and "on" in command and "freezer" in command:
#     print ("turning on your freezer")

# if ("turn" in command or "switch" in command or "put" in command) and "on" in command and "oven" in command:
#     print ("turning on your oven")

# if ("turn" in command or "switch" in command or "put" in command) and "on" in command and "heat" in command and "pump" in command :
#     print ("turning on your pump")

# if ("turn" in command or "switch" in command or "put" in command) and "on" in command and "air" in command and "conditioner" in command :
#     print ("turning on your air conditioner")

# if ("turn" in command or "switch" in command or "put" in command) and "on" in command and "microwave" in command:
#     print ("turning on your microwave")

# if ("turn" in command or "switch" in command or "put" in command) and "on" in command and "water" in command and "pump" in command :
#     print ("turning on your water pump")

# if ("turn" in command or "switch" in command or "put" in command) and "on" in command and "utilities" in command:
#     print ("turning on your utilities")

# if ("turn" in command or "switch" in command or "put" in command) and "on" in command and "e" in command and "v" in command:
#     print ("turning on your ev")

#     #---------------------------OFF------------------------------------------#

# if ("turn" in command or "switch" in command or "put" in command) and "off" in command and "washing" in command and "machine" in command:
#     print ("turning off your washing machine")

# if ("turn" in command or "switch" in command or "put" in command) and "off" in command and "dryer" in command:
#     print ("turning off your dryer")

# if ("turn" in command or "switch" in command or "put" in command) and "off" in command and "fridge" in command:
#     print ("turning off your fridge")

# if ("turn" in command or "switch" in command or "put" in command) and "off" in command and "freezer" in command:
#     print ("turning off your freezer")

# if ("turn" in command or "switch" in command or "put" in command) and "off" in command and "oven" in command:
#     print ("turning off your oven")

# if ("turn" in command or "switch" in command or "put" in command) and "off" in command and "heat" in command and "pump" in command :
#     print ("turning off your pump")

# if ("turn" in command or "switch" in command or "put" in command) and "off" in command and "air" in command and "conditioner" in command :
#     print ("turning off your air conditioner")

# if ("turn" in command or "switch" in command or "put" in command) and "off" in command and "microwave" in command:
#     print ("turning off your microwave")

# if ("turn" in command or "switch" in command or "put" in command) and "off" in command and "water" in command and "pump" in command :
#     print ("turning off your water pump")

# if ("turn" in command or "switch" in command or "put" in command) and "off" in command and "utilities" in command:
#     print ("turning off your utilities")

# if ("turn" in command or "switch" in command or "put" in command) and "off" in command and "e" in command and "v" in command:
#     print ("turning off your ev")

#         #---------------------------ACTIVATE------------------------------------------#

# if ("activate" in command or "start" in command or "charge" in command)  and "washing" in command and "machine" in command:
#     print ("turning on your washing machine")

# if ("activate" in command or "start" in command or "charge" in command) and "dryer" in command:
#     print ("turning on your dryer")

# if ("activate" in command or "start" in command or "charge" in command) and "fridge" in command:
#     print ("turning on your fridge")

# if ("activate" in command or "start" in command or "charge" in command) and "freezer" in command:
#     print ("turning on your freezer")

# if ("activate" in command or "start" in command or "charge" in command) and "oven" in command:
#     print ("turning on your oven")

# if ("activate" in command or "start" in command or "charge" in command) and "heat" in command and "pump" in command :
#     print ("turning on your pump")

# if ("activate" in command or "start" in command or "charge" in command) and "air" in command and "conditioner" in command :
#     print ("turning on your air conditioner")

# if ("activate" in command or "start" in command or "charge" in command) and "microwave" in command:
#     print ("turning on your microwave")

# if ("activate" in command or "start" in command or "charge" in command) and "water" in command and "pump" in command :
#     print ("turning on your water pump")

# if ("activate" in command or "start" in command or "charge" in command) and "utilities" in command:
#     print ("turning on your utilities")

# if ("activate" in command or "start" in command or "charge" in command) and "e" in command and "v" in command:
#     print ("turning on your ev")

#         #---------------------------all devices------------------------------------------#

# if ("turn" in command or "switch" in command or "put" in command) and "on" in command and "all" in command and "device" in command:
#     print ("turning on all your devices")

# if ("turn" in command or "switch" in command or "put" in command) and "off" in command and "all" in command and "device" in command:
#     print ("turning off all your devices")

# if ("activate" in command or "start" in command or "charge" in command) and "all" in command and "device" in command:
#     print ("turning on your all device")



if ("turn" in command or "switch" in command or "put" in command) and "off" in command and "all" in command and "device" in command and "except" in command:
    devices = ["washing machine","dryer","fridge","freezer","oven","heat pump","air conditioner","microwave","water pump","utilities","ev"]
    i= command.index("except")
    e = len(command)
    d = command[i:e]
    f = list (filter(lambda x: x not in d,devices))
    for x in f:
        print ("turning off :", x)


elif ("turn" in command or "switch" in command or "put" in command) and "off" in command and "all" in command and "device" in command:
    devices = ["washing machine","dryer","fridge","freezer","oven","heat pump","air conditioner","microwave","water pump","utilities","ev"]
    for x in devices:
        print ("turning off :", x)

elif ("turn" in command or "switch" in command or "put" in command) and "off" in command and ("washing machine" in command or "dryer" in command or "fridge" in command or "freezer" in command or"oven" in commandor or "heat pump" in command or "air conditioner" in command or "microwave" in command or "water pump" in command or "utilities" in command or "ev" in command  ):
    devices = ["washing machine","dryer","fridge","freezer","oven","heat pump","air conditioner","microwave","water pump","utilities","ev"]

    f = list (filter(lambda x: x in command,devices))
    for x in f:
        print ("turning off :", x)







