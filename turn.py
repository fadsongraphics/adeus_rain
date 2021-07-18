text = str (input ("type a command"))

command = text.split()

print (command)


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


if ("turn" in command or "switch" in command or "put" in command) and "on" in command and "all" in command and "device" in command and "except" in command:
    devices = ["washing machine","dryer","fridge","freezer","oven","heat pump","air conditioner","microwave","water pump","utilities","ev"]
    i= command.index("except")
    e = len(command)
    d = command[i:e]
    f = list (filter(lambda x: x not in d,devices))
    for x in f:
        print ("turning on :", x)


elif ("turn" in command or "switch" in command or "put" in command) and "on" in command and "all" in command and "device" in command:
    devices = ["washing machine","dryer","fridge","freezer","oven","heat pump","air conditioner","microwave","water pump","utilities","ev"]
    for x in devices:
        print ("turning on :", x)

elif ("turn" in command or "switch" in command or "put" in command) and "on" in command and ("washing machine" in command or "dryer" in command or "fridge" in command or "freezer" in command or"oven" in commandor or "heat pump" in command or "air conditioner" in command or "microwave" in command or "water pump" in command or "utilities" in command or "ev" in command  ):
    devices = ["washing machine","dryer","fridge","freezer","oven","heat pump","air conditioner","microwave","water pump","utilities","ev"]

    f = list (filter(lambda x: x in command,devices))
    for x in f:
        print ("turning on :", x)








