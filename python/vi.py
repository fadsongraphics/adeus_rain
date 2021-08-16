import soundfile as sf
import sounddevice as sd
import argparse 
import os
import queue
import vosk
import sys
import json
import pyttsx3
import wordtodigits
import pandas as pd
import numpy as np
import math
from sklearn.feature_extraction.text import CountVectorizer
from sklearn.metrics.pairwise import cosine_similarity
import requests
import re
##import simpleaudio as sa
from datetime import datetime
import time
import pygame

pygame.mixer.init()


soundObjnegative = pygame.mixer.Sound('negativea.wav')
soundObjhundred = pygame.mixer.Sound ('hundreda.wav')
soundObjmillion = pygame.mixer.Sound('milliona.wav')
soundObjthousand = pygame.mixer.Sound('thousanda.wav')
soundObjbillion = pygame.mixer.Sound('billiona.wav')
soundObjfridge = pygame.mixer.Sound('fridge.wav')
soundObjtv = pygame.mixer.Sound('tv.wav')
soundObjtelevision = pygame.mixer.Sound('television.wav')
soundObjac = pygame.mixer.Sound('ac.wav')
soundObjair_conditioner = pygame.mixer.Sound('air conditioner.wav')
soundObjpump = pygame.mixer.Sound('pump.wav')
soundObjwashing_machine = pygame.mixer.Sound('washing machine.wav')
soundObjdryer = pygame.mixer.Sound('dryer.wav')
#soundObjcooking_oven = pygame.mixer.Sound('oven.wav')
soundObjfreezer = pygame.mixer.Sound('freezer.wav')
soundObjmicrowave = pygame.mixer.Sound('microwave.wav')
soundObjev = pygame.mixer.Sound('ev.wav')
soundObjprinter = pygame.mixer.Sound('printer.wav')
soundObjbulb = pygame.mixer.Sound('bulb.wav')

#soundObjwater_pump = pygame.mixer.Sound('water pump.wav')
soundObjheater = pygame.mixer.Sound('heater.wav')
soundObjcooker = pygame.mixer.Sound('cooker.wav')
soundObjkettle = pygame.mixer.Sound('kettle.wav')
soundObjlight = pygame.mixer.Sound('light.wav')
soundObjspeaker = pygame.mixer.Sound('speaker.wav')
soundObjrefridgerator = pygame.mixer.Sound('refridgerator.wav')
soundObjfan = pygame.mixer.Sound('fan.wav')
soundObjand = pygame.mixer.Sound('&a.wav')
soundObj0a = pygame.mixer.Sound('0a.wav')
soundObj1a = pygame.mixer.Sound('1a.wav')
soundObj2a = pygame.mixer.Sound('2a.wav')
soundObj3a = pygame.mixer.Sound('3a.wav')
soundObj4a = pygame.mixer.Sound('4a.wav')
soundObj5a = pygame.mixer.Sound('5a.wav')
soundObj6a = pygame.mixer.Sound('6a.wav')
soundObj7a = pygame.mixer.Sound('7a.wav')
soundObj8a = pygame.mixer.Sound('8a.wav')
soundObj9a = pygame.mixer.Sound('9a.wav')
soundObj10a = pygame.mixer.Sound('10a.wav')
soundObj11a = pygame.mixer.Sound('11a.wav')
soundObj12a = pygame.mixer.Sound('12a.wav')
soundObj13a = pygame.mixer.Sound('13a.wav')
soundObj14a = pygame.mixer.Sound('14a.wav')
soundObj15a = pygame.mixer.Sound('15a.wav')
soundObj16a = pygame.mixer.Sound('16a.wav')
soundObj17a = pygame.mixer.Sound('17a.wav')
soundObj18a = pygame.mixer.Sound('18a.wav')
soundObj19a = pygame.mixer.Sound('19a.wav')
soundObj20a = pygame.mixer.Sound('20a.wav')
soundObjpoint = pygame.mixer.Sound('pointa.wav')
soundObj = pygame.mixer.Sound('Beginning.wav')
soundObj1 = pygame.mixer.Sound('1.wav')
soundObj2 = pygame.mixer.Sound('2.wav')
soundObj3 = pygame.mixer.Sound('3.wav')
soundObj4 = pygame.mixer.Sound('4.wav')
soundObj5 = pygame.mixer.Sound('5.wav')
soundObj6 = pygame.mixer.Sound('6.wav')
soundObj7 = pygame.mixer.Sound('7.wav')
soundObj8 = pygame.mixer.Sound('8.wav')
soundObj9 = pygame.mixer.Sound('9.wav')
soundObj10 = pygame.mixer.Sound('10.wav')
soundObj11 = pygame.mixer.Sound('11.wav')
soundObj12 = pygame.mixer.Sound('12.wav')
soundObj13 = pygame.mixer.Sound('13.wav')
soundObj14 = pygame.mixer.Sound('14.wav')
soundObj15 = pygame.mixer.Sound('15.wav')
soundObj16 = pygame.mixer.Sound('16.wav')
soundObj17 = pygame.mixer.Sound('17.wav')
soundObj18 = pygame.mixer.Sound('18.wav')
soundObj19 = pygame.mixer.Sound('19.wav')
soundObj20 = pygame.mixer.Sound('20.wav')
soundObj21 = pygame.mixer.Sound('21.wav')
soundObj22 = pygame.mixer.Sound('22.wav')
soundObj23 = pygame.mixer.Sound('23.wav')
soundObj24 = pygame.mixer.Sound('24.wav')
soundObj25 = pygame.mixer.Sound('25.wav')
soundObj26 = pygame.mixer.Sound('26.wav')
soundObj27 = pygame.mixer.Sound('27.wav')
soundObj28 = pygame.mixer.Sound('28.wav')
soundObj29 = pygame.mixer.Sound('29.wav')
soundObj30 = pygame.mixer.Sound('30.wav')
soundObj31 = pygame.mixer.Sound('31.wav')
soundObj32 = pygame.mixer.Sound('32.wav')
soundObj33 = pygame.mixer.Sound('33.wav')
soundObj34 = pygame.mixer.Sound('34.wav')
soundObj35 = pygame.mixer.Sound('35.wav')
soundObj36 = pygame.mixer.Sound('36.wav')
soundObj37 = pygame.mixer.Sound('37.wav')
soundObj38 = pygame.mixer.Sound('38.wav')
soundObj39 = pygame.mixer.Sound('39.wav')
soundObja = pygame.mixer.Sound('bbm_tone.wav')
soundObjb = pygame.mixer.Sound('Pipes.wav')
soundObjrun = pygame.mixer.Sound('run.wav')
soundObjpull = pygame.mixer.Sound('pull.wav')
soundObjkwg = pygame.mixer.Sound('kwg.wav')
soundObjeeb = pygame.mixer.Sound('eeb.wav')
soundObjunit = pygame.mixer.Sound('unit.wav')






df = pd.read_csv('Intents.csv', header = None, names = ['Examples', 'Intent'])
device = []
appliances= ['fridge', 'tv', 'television', 'ac','air conditioner','pump','washing machine','dryer','cooking oven','freezer', 'microwave','ev','printer',
              'bulb','water pump','heater','cooker','kettle','light','speaker','refrigerator','fan']
currencies = ['dollars', 'pounds', 'euros', 'naira', 'yuan', 'canadian dollars', 'canadian dollar', 'australian dollars', 'australian dollar',
              'dollar','pound' , 'euro']
times = ['today', 'yesterday', 'last week', 'last month', 'a month ago', 'two days ago', 'two months ago', 'three days ago', 'one month', 'one day']
quantity = []
currency = []
period= []


def get_intent(text):
  global device, quantity, currency, period
  quantity = []
  currency = []
  examples_list = df['Examples'].tolist()
  quantity = list (map(int, re.findall(r'\d+', text)))
  device_check = any(appliance in text.lower() for appliance in appliances)
  currency_check  = any(currency in text.lower() for currency in currencies)
  period_check = any(time in text.lower() for time in times)
  if period_check:
    period = list(set(times).intersection(set(text.split())))
  if currency_check:
    currency =list(set(currencies).intersection(set(text.split())))
  if not 'device' in text.lower():
    if device_check:
      device =list(set(appliances).intersection(set(text.split())))
      for d in device:
        text = text.replace(d, 'device')
  elif 'it' in text.lower():
    pass
  else:
    device = []
  text = [text]
  cv = CountVectorizer()
  vectors = cv.fit_transform(examples_list+text).toarray()
  vectors_list = [vec for vec in vectors]
  similarity_scores = cosine_similarity(vectors_list)[-1][:-1]
  i=np.argmax(similarity_scores)
  intent = df[df['Examples'] == examples_list[i]]['Intent'].values[0].strip()
  return intent

def intent2action(intent):
  text = ''
  global device, quantity, currency
  if intent == 'Utilities_Device_status':
     
    if device:
        
      for d in device:
        
        
        address= fr"http://localhost/nlp?key=passkey&device={d}&get_state=1"
        address = address.replace(' ', '%20')
        web_res  = requests.get(address).json() 
        response =  web_res['response']
        if web_res['status']==0:
            text+= f'{response}'
        else:#get status from db
          soundObj21.play()
          time.sleep(2)
          
          #text += f'{d}'
          # dev = 'soundObj'+ d 
          # print(dev)
          pygame.mixer.Sound( d+ '.wav').play()
          time.sleep(1)

          soundObj22.play()
          time.sleep(2)
          text += f'{response}'

    else:
      soundObj1.play()
      time.sleep(2)

  elif intent == 'Utilities_Device_Usage':

    if device and period:
      for d in device:
        address = fr"http://localhost/nlp?key=passkey&device={d}&get_energy=1&period={period}"
        address = address.replace(' ', '%20')
        
        web_res = requests.get(address).json()
        usage = web_res['response']

        soundObj21.play()
        time.sleep(1)

        #text += f'{d}'
        dev = 'soundObj'+ d
        print(dev)
        pygame.mixer.Sound( d+ '.wav').play()
        time.sleep(1)

        soundObj23.play()
        time.sleep(1)

        text += f'{period}'

        soundObj24.play()
        time.sleep(1)

        #text += f'.{usage}.'
        sayeed (float (usage))
        time.sleep(1)

        soundObj25.play()
        time.sleep(1)


    elif device:
      address = fr"http://localhost/nlp?key=passkey&device={d}&get_energy=1&period=today"
      address = address.replace(' ', '%20')
      web_res = requests.get(address).json()
      usage = web_res['response']


      soundObj39.play()
      time.sleep(1)

      #text += f'.{usage}.'
      sayeed (float (usage))
      time.sleep(1)

    else:
      soundObj1.play()
      time.sleep(1)
  elif intent == 'current_power':
        
        address = fr"http://localhost/nlp?get_power=1"
        address = address.replace(' ', '%20')
        web_res = requests.get(address).json()
        current_power = web_res['response']
        soundObjpull.play()
        time.sleep(2)
        sayeed (current_power)
        time.sleep(2)
        soundObjkwg.play()

  elif intent == 'energy_ever_bought':
        address = fr"http://localhost/nlp?get_eeb=1"
        address = address.replace(' ', '%20')
        web_res = requests.get(address).json()
        energy_ever_bought = web_res['response']
        soundObjeeb.play()
        time.sleep(2)
        sayeed (energy_ever_bought)
        time.sleep(2)
        soundObjunit.play()







        

  elif intent == 'Turn_off_device':
    if device:
      for d in device:
        address = fr"http://localhost/nlp?key=passkey&device={d}&turn_off=1"
        address = address.replace(' ', '%20')
        web_res = requests.post(address).json()

        soundObj26.play()
        time.sleep(2)

        #text += f'{d}'
        dev = 'soundObj'+ d
        print(dev)
        pygame.mixer.Sound( d + '.wav').play()
        time.sleep(1)

    else:
      soundObj2.play()
      time.sleep(2)

  elif intent == 'Turn_on_device':
    if device:
      for d in device:
        address = fr"http://localhost/nlp?key=passkey&device={d}&turn_on=1"
        address = address.replace(' ', '%20')
        web_res= requests.post(address).json()

        soundObj27.play()
        time.sleep(2)

        #text += f'{d}'
        dev = 'soundObj'+ d
        print(dev)
        pygame.mixer.Sound( d+ '.wav').play()
        time.sleep(1)
    else:
      soundObj3.play()
      time.sleep(2)

  elif intent == 'Utilities_Energy_Balance':
      address = fr"http://localhost/nlp?key=passkey&get_balance=1"
      address = address.replace(' ', '%20')
      web_res = requests.get(address).json()
      balance = web_res['response']
      
      soundObj28.play()
      time.sleep(2)

      
      #print(balance)
      #print(balance*2)
      sayeed (float(balance))
      time.sleep(1)

      soundObj25.play()
      time.sleep(0.5)

  elif intent == 'Utilities_energy_price':
      address = fr"http://localhost/nlp?key=passkey&get_price=1"
      address = address.replace(' ', '%20')
      web_res= requests.get(address).json()
      price = web_res['response'] 
      if quantity and currency:

        soundObj29.play()
        time.sleep(2)

        text+= f'.{quantity[0]/price}.'

        soundObj30.play()
        time.sleep(2)

        text+= f'{quantity[0]} {currency[0]}'

      elif quantity:
        price = price * quantity[0]

        soundObj31.play()
        time.sleep(2)

        text += f'{quantity[0]}'

        soundObj32.play()
        time.sleep(2)

        text += f'{price}'


      else:

        soundObj33.play()
        time.sleep(2)

        text += f'{price}'

  elif intent == 'Utilities_Recharge_Account':
    if quantity and currency:

      soundObj34.play()
      time.sleep(5)

      text += f'{quantity[0]} {currency[0]}'

    elif quantity:

      soundObj35.play()
      time.sleep(2)

      text += f'{quantity[0]}'

      soundObj25.play()
      time.sleep(2)

    else:
      soundObj4.play()
      time.sleep(2)
      
   

  elif intent == 'Utilities_View_Usage':
    if period:
      address = fr"http://localhost/nlp?key=passkey&get_energy=1&period={period}"
      address = address.replace(' ', '%20')
      web_res = requests.get(address).json()
      usage = web_res['response']

      soundObj36.play()
      time.sleep(2)
      

      text += f'{period[0]}'
      

      soundObj24.play()
      time.sleep(2)
     
      #text += f'{usage}'
      print (usage)
      sayeed (float (usage))
      time.sleep(2)

      soundObj25.play()
      time.sleep(2)



    else:
          
      address = fr"http://localhost/nlp?key=passkey&get_energy=1&period=today"
      address = address = address.replace(' ', '%20')
      web_res = requests.get(address).json()
      usage = web_res['response']

      soundObj37.play()
      time.sleep(2)

    
      #text += f"{usage}"
      print (usage)
      sayeed (float (usage))
      time.sleep(2)
      soundObj25.play()
      

  # elif intent == 'Age':
  #   filename = '5.wav'
  #   data, fs = sf.read(filename, dtype='float32')
  #   #sd.play(data, fs)
  #   status = sd.wait()
  #   soundObj5.play()
  #   time.sleep(2)

  elif intent == 'Ask_question':
    soundObj6.play()
    time.sleep(2)
    t="Sure how can I be of help?"
    
    soundObja.play()

  elif intent == 'Bored':
    soundObj7.play()
    time.sleep(2)
    t="So sorry about that"
    not_done_with_Q= False
    soundObja.play()

  elif intent == 'Love':
    soundObj8.play()
    time.sleep(5)
    t="I'm happy being single. the upside is I get to focus on managing your Energy"
    not_done_with_Q= False
    soundObja.play()


  elif intent == 'Compliment':
    soundObj9.play()
    time.sleep(2)
    t="Oh!, thank you. i'm blushing right now!."
    not_done_with_Q= False
    soundObja.play()

  
  elif intent == 'Hobby':
    soundObj10.play()
    time.sleep(2)
    t="I love to help you manage your energy"
    stoplistening ()
    not_done_with_Q= False
    soundObja.play()


  elif intent == 'get_personal':
    soundObj11.play()
    time.sleep(2)
    t="I,m your energy concierge!"
    not_done_with_Q= False
    soundObja.play()


  elif intent == 'Pissed':
    soundObj12.play()
    time.sleep(5)
    t="sorry!, boss!!"
    not_done_with_Q= False
    soundObja.play()


  elif intent == 'Language':
    soundObj13.play()
    time.sleep(5)
    t="I speak English. Visit your language settings to change"
    not_done_with_Q= False
    soundObja.play()


  elif intent == 'Boss':
    soundObj14.play()
    time.sleep(2)
    t="I was made by Robotics & Artificial Intelligence Nigeria."
    not_done_with_Q= False
    soundObja.play()
    


  elif intent == 'Retraining':
    soundObj15.play()
    time.sleep(2)
    t="I learn everyday!"
    not_done_with_Q= False
    soundObja.play()



  elif intent == 'Job':
    soundObj16.play()
    time.sleep(2)
    t="I'm always happy to help!"
    not_done_with_Q= False
    soundObja.play()


  #elif intent == 'know_weather':
    #text+= f"The weather today is..." #get from db

  elif intent == 'know_date':
        
    # d2 = today.strftime("%B %d, %Y")

    # soundObj38.play()
    # time.sleep(2)
    
    # text+= f"{d2}" 
    today = datetime.now()
    stephen ()
    time.sleep(0.5)
    not_done_with_Q= False
    soundObja.play()

  elif intent == 'End_conversation':
    soundObj17.play()
    time.sleep(2)
    t="I'm happy I was able to help"
    not_done_with_Q= False
    soundObja.play()

    
  elif intent == 'Ask_question':

    soundObj18.play()
    time.sleep(2)
    t="Sure how can I help?"
    not_done_with_Q= False
    soundObja.play()

    
  elif intent == 'greeting':

    soundObj19.play()
    time.sleep(2)
    t="Hey! How may I be of assistance?"
    not_done_with_Q= False
    soundObja.play()

      
  elif intent == 'Utilities_Report_Outage':
    soundObjb.play()
    time.sleep(7)
    t="Our team will respond, to your request! as soon as possible."
    not_done_with_Q= False
    soundObja.play()

      
  elif intent == 'Utilities_Start_Service':
    soundObjb.play()
    time.sleep(7)
    t="Our team will respond, to your request! as soon as possible."
    not_done_with_Q= False
    soundObja.play()
      
  elif intent == 'Utilities_Stop_Service':
    soundObjb.play()
    time.sleep(7)
    t="Our team will respond, to your request! as soon as possible."
    not_done_with_Q= False
    soundObja.play()

  elif intent == 'Nigeria':
    text += f'I was built by rain in Nigeria'
    not_done_with_Q= False
    soundObja.play()

      
  else:

    soundObjb.play()
    time.sleep(2) 
    not_done_with_Q= False
    

  


  return text
      



def speakword(text):

  if text !='':
    engine = pyttsx3.init()
    voices = engine.getProperty('voices')
    engine.setProperty('voice', voices[1].id)
    engine.setProperty('rate', 140)
    engine.say(text)
    engine.runAndWait()

q = queue.Queue()

def stoplistening ():

  not_done_with_Q= False


def sayeed (num):
    td=0.5

    if num==0:
          
         soundObj0a.play()
         time.sleep (td)


    if num < 0:
        soundObjnegative.play()
        time.sleep (td)

    x = abs(num)

    if x >= 1000000000:
        n = math.floor(x/1000000000)
        a=  str(n) + '.wav' 
        pygame.mixer.init()
        pygame.mixer.Sound(a).play()
        sayeed (n)
        time.sleep (td)
        soundObjbillion.play()
        time.sleep (td)

        x = x-(n*1000000000)
        # while True :
        #     if b!=0:
        #         sayeed (b)
        #     else:
        #         break
        


    if x >= 1000000:
        n = math.floor(x/1000000)
        a=  str(n) + 'a.wav' 
        pygame.mixer.init()
        pygame.mixer.Sound(a).play()
        sayeed (n)
        time.sleep (td)
        soundObjmillion.play()
        time.sleep (td)

        x = x-(n*1000000)
        # while True :
        #     if b!=0:
        #         sayeed (b)
        #     else:
        #         break

    if x >= 1000:
        n = math.floor(x/1000)
        a=  str(n) + 'a.wav' 
        pygame.mixer.init()
        pygame.mixer.Sound(a).play()
        sayeed (n)
        time.sleep (td)
        soundObjthousand.play()
        time.sleep (td)

        x = x-(n*1000)
        # while True :
        #     if b!=0:
        #         sayeed (b)
        #     else:
        #         break
    
    
    if x >= 100:
        n = math.floor(x/100)
        a=  str(n) + 'a.wav' 
        pygame.mixer.init()
        pygame.mixer.Sound(a).play()
        time.sleep (td)
        soundObjhundred.play()
        time.sleep (td)
        x = x-(n*100)
        time.sleep (td)
        if x > 0:
            soundObjand.play()
            time.sleep (td)

        
        # while True :
        #     if b!=0:
        #         sayeed (b)
        #     else:
        #         break

    

    if x >= 20:
        n = math.floor(x/10)
        a=  str(10*n) + 'a.wav' 
        pygame.mixer.init()
        pygame.mixer.Sound(a).play()
        time.sleep (td)
        x = x-(10*n)
        # while True :
        #     if b!=0:
        #         sayeed (b)
        #     else:
        #         break

    if x >= 1:
        n = math.floor(x)
        x = round(x-n,3)

        if n == 19:
            soundObj19a.play()
            time.sleep (td)

        if n == 18:
            soundObj18a.play()
            time.sleep (td)

        if n == 17:
            soundObj17a.play()
            time.sleep (td)

        if n == 16:
            soundObj16a.play()
            time.sleep (td)
        
        if n == 15:
            soundObj15a.play()
            time.sleep (td)

        if n == 14:
            soundObj14a.play()
            time.sleep (td)

        if n == 13:
            soundObj13a.play()
            time.sleep (td)

        if n == 12:
            soundObj12a.play()
            time.sleep (td)

        if n == 11:
            soundObj11a.play()
            time.sleep (td)

        if n == 10:
            soundObj10a.play()
            time.sleep (td)

        if n == 9:
            soundObj9a.play()
            time.sleep (td)

        if n == 8:
            soundObj8a.play()
            time.sleep (td)

        if n == 7:
            soundObj7a.play()
            time.sleep (td)

        if n == 6:
            soundObj6a.play()
            time.sleep (td)

        if n == 5:
            soundObj5a.play()
            time.sleep (td)

        if n == 4:
            soundObj4a.play()
            time.sleep (td)

        if n == 3:
            soundObj3a.play()
            time.sleep (td)

        if n == 2:
            soundObj2a.play()
            time.sleep (td)

        if n == 1:
            soundObj1a.play()
            time.sleep (td)
        

    if x > 0:
        soundObjpoint.play()
        time.sleep (td)
        n = math.floor(x/0.1)
        a=  str(n) + 'a.wav' 
        pygame.mixer.init()
        pygame.mixer.Sound(a).play()
        time.sleep (td)
        x = x - (n*0.1)
        
        if x > 0:
            n = math.floor(x/0.01)
            a=  str(n) + 'a.wav' 
            pygame.mixer.init()
            pygame.mixer.Sound(a).play()
            time.sleep (td)
            x = x - (n*0.01)

            if x > 0:
                n = math.floor(x/0.001)
                a=  str(n) + 'a.wav' 
                pygame.mixer.init()
                pygame.mixer.Sound(a).play()
                time.sleep (td)
                x = x - (n*0.001)

def stephen ():
      
    
    today = datetime.now()
    d2 = today.strftime("%B")
    d7 = today.strftime("%A")

   
    d3 = int(today.strftime("%d"))
    d4 = int(today.strftime("%Y"))
    d5 = int(today.strftime("%H"))

    if d5 > 11:
        ampm ='pm'
    else:
        ampm = 'am'
    
    if d5 > 12:
        d5=d5-12

    if d5 ==0:
        d5 = 12
    
    
    d6 = int (today.strftime('%M'))

    d4a = math.floor(d4/100)
    d4b = d4-(d4a*100)
    pygame.mixer.init()
#this says the time

    sayeed (d5)
    time.sleep (0.5)
    sayeed (d6)
    time.sleep (0.5)
    pygame.mixer.Sound(ampm + 'a.wav').play()
    time.sleep (2)

    pygame.mixer.init()
    pygame.mixer.Sound(d7.lower() + 'a.wav').play()
    time.sleep (1)



#this says the date
    pygame.mixer.init()
    pygame.mixer.Sound(d2.lower() + 'a.wav').play()
    time.sleep (1)

    sayeed (d3)
    time.sleep (1)
    sayeed (d4a)
    time.sleep (0.2)
    sayeed (d4b)
    time.sleep (0.2)   
    

def int_or_str(text):
    """Helper function for argument parsing."""
    try:
        return int(text)
    except ValueError:
        return text

def callback(indata, frames, time, status):
    """This is called (from a separate thread) for each audio block."""
    if status:
        print(status, file=sys.stderr)
    q.put(bytes(indata))

    
parser = argparse.ArgumentParser(add_help=False)
parser.add_argument(
    '-l', '--list-devices', action='store_true',
    help='show list of audio devices and exit')
args, remaining = parser.parse_known_args()
if args.list_devices:
    print(sd.query_devices())
    parser.exit(0)
parser = argparse.ArgumentParser(
    description=__doc__,
    formatter_class=argparse.RawDescriptionHelpFormatter,
    parents=[parser])
parser.add_argument(
    '-f', '--filename', type=str, metavar='FILENAME',
    help='audio file to store recording to')
parser.add_argument(
    '-m', '--model', type=str, metavar='MODEL_PATH',
    help='Path to the model')
parser.add_argument(
    '-d', '--device', type=int_or_str,
    help='input device (numeric ID or substring)')
parser.add_argument(
    '-r', '--samplerate', type=int, help='sampling rate')
args = parser.parse_args(remaining)

try:
    if args.model is None:
        args.model = "model"
    if not os.path.exists(args.model):
        print ("Please download a model for your language from https://alphacephei.com/vosk/models")
        print ("and unpack as 'model' in the current folder.")
        parser.exit(0)
    if args.samplerate is None:
        device_info = sd.query_devices(args.device, 'input')
        # soundfile expects an int, sounddevice provides a float:
        args.samplerate = int(device_info['default_samplerate'])

    model = vosk.Model(args.model)

    if args.filename:
        dump_fn = open(args.filename, "wb")
    else:
        dump_fn = None

    with sd.RawInputStream(samplerate=args.samplerate, blocksize = 16000, device=args.device, dtype='int16',
                            channels=1, callback=callback):
            print('#' * 80)
            print('Press Ctrl+C to stop the recording')
            print('#' * 80)

            rec = vosk.KaldiRecognizer(model, args.samplerate)
            juststarting = True
            while True:
                if juststarting:
                      
                      pygame.mixer.Sound('intro1.wav').play()
                      time.sleep (9)
                      address = fr"http://localhost/nlp?key=passkey&get_balance=1"
                      address = address.replace(' ', '%20')
                      web_res = requests.get(address).json()
                      balance = web_res['response']
                      sayeed(float(balance))
                      time.sleep(1)
                      soundObj25.play()
                      time.sleep(1)
                      pygame.mixer.Sound('intro2.wav').play()
                      time.sleep (8)
                      juststarting = False
                data = q.get()
                if rec.AcceptWaveform(data):
                    jres = json.loads((rec.Result()))
                    print (jres['text']) 
                    
                    if ("hello vivian" in jres["text"]) or ("hello" in jres["text"]) or ("vivian" in jres["text"]):
                        address = fr"http://localhost/nlp?trigger=true"
                        requests.get(address)
                        
                        # filename = 'Beginning.wav'
                        # data, fs = sf.read(filename, dtype='float32')
                        # # sd.play(data, fs)
                        # status = sd.wait()
                        soundObj.play()

                        #soundObjrun.play()

                        not_done_with_Q= True

                        

                    
                        
                        
                        

                        
                        
                        
                        
                        
                        while not_done_with_Q:
                              
                             
                            data= q.get()

                            if rec.AcceptWaveform(data):
                                jres = json.loads((rec.Result()))
                                print (jres['text'])    
                           
                                if jres['text'] != '':
                                  jres['text'].replace ('fun','fan')
                                  jres['text'].replace ('reason','freezer')
                                  finaltext= wordtodigits.convert((jres["text"]))
                                  user_intent = get_intent(finaltext)
                                  print("Intent: " + user_intent)
                                  adeus_reply = intent2action(user_intent)
                                  print(adeus_reply)
  
                                  f = open("nlp_q.txt","w")
                                  f.write(jres['text'])
                                  f.close()

                                  f2 = open("nlp_r.txt","w")
                                  f2.write(adeus_reply)
                                  f2.close()

                                  

                                  if adeus_reply.startswith('Which device do you'):
                                      
                                      speakword(adeus_reply)
                                      q.queue.clear()
                                      time.sleep(2)
                                      while True: 
                                          data = q.get()
                                          if rec.AcceptWaveform(data):
                                              jres = json.loads(rec.Result())
                                              finaltext = wordtodigits.convert(jres["text"])
                                              print(jres["text"])
                                              device_check = any(appliance in finaltext.lower() for appliance in appliances)
                                              if device_check:
                                                  device =list(set(appliances).intersection(set(finaltext.split())))
                                                  print(device)
                                                  adeus_reply= intent2action(user_intent)
                                                  speakword(adeus_reply)
                                                  q.queue.clear()
                                                  break
                                              
                                          
                                              else:
                                                  speakword("please respond with a device name")
                                                  q.queue.clear()
                                              
                                      
                                          
                                          
                                  elif adeus_reply.startswith('How many kilowatts'):
                                      speakword(adeus_reply)
                                      q.queue.clear()
                                      time.sleep(2)
                                      while True:
                                          data = q.get()
                                          if rec.AcceptWaveform(data):
                                              jres = json.loads(rec.Result())
                                              print(jres["text"])
                                              finaltext = wordtodigits.convert(jres["text"])
                                              quantity = list (map(int, re.findall(r'\d+', finaltext)))
                                              currency_check  = any(currency in finaltext.lower() for currency in currencies)
                                              if currency_check and quantity:
                                                  currency = list(set(currencies).intersection(set(finaltext.split())))
                                                  adeus_reply = intent2action(user_intent)
                                                  speakword(adeus_reply)
                                                  q.queue.clear()
                                                  break
                                              elif quantity:
                                                  adeus_reply = intent2action(user_intent)
                                                  print(user_intent)
                                                  speakword(adeus_reply)
                                                  q.queue.clear()
                                                  break
                                              else:
                                                  speakword("please respond with how much energy you need")
                                                  q.queue.clear()
                                                  
                                  elif adeus_reply.startswith('For which period'):
                                      speakword(adeus_reply)
                                      q.queue.clear()
                                      while True:          
                                          data = q.get()
                                          rec.AcceptWaveform(data)
                                          jres = json.loads(rec.Result())
                                          finaltext = wordtodigits.convert(jres["text"])
                                          quantity = list (map(int, re.findall(r'\d+', finaltext)))
                                          period_check  = any(time in finaltext.lower() for time in times)
                                          if period_check:
                                              period = list(set(times).intersection(set(finaltext.split())))
                                              adeus_reply = intent2action(user_intent)
                                              speakword(adeus_reply)
                                              q.queue.clear()
                                              break
                                          else:
                                              speakword("please respond with the period you want ")
                                                          
                                                          
                                  else:
                                      speakword(adeus_reply)
                                      q.queue.clear()
                                      address = fr"http://localhost/nlp?trigger=false"
                                      requests.get(address)
                                
                                      not_done_with_Q= False
                                      #filename = 'bbm_tone.wav'
                                      #data, fs = sf.read(filename, dtype='float32')
                                      # sd.play(data, fs)
                                      #status = sd.wait()
                                      
                            
                            if ("thank you" in jres["text"]) or ("bye" in jres["text"]):
                                address = fr"http://localhost/nlp?trigger=false"
                                requests.get(address)
                                
                                not_done_with_Q= False
                                filename = 'bbm_tone.wav'
                                data, fs = sf.read(filename, dtype='float32')
                                # sd.play(data, fs)
                                status = sd.wait()
                                soundObja.play()

                    
                                
                                                            
                                                            
                                                           
except KeyboardInterrupt:
    print('\nDone')
    parser.exit(0)
except Exception as e:
    parser.exit(type(e).__name__ + ': ' + str(e))
