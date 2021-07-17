import math
import pygame
import time

from datetime import datetime


#today = date.today()
today = datetime.now() # current date and time



pygame.mixer.init()
soundObjnegative = pygame.mixer.Sound('negative.wav')
soundObjhundred = pygame.mixer.Sound ('hundred.wav')
soundObjmillion = pygame.mixer.Sound('million.wav')
soundObjthousand = pygame.mixer.Sound('thousand.wav')
soundObjbillion = pygame.mixer.Sound('billion.wav')
soundObjand = pygame.mixer.Sound('&.wav')
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
soundObjpoint = pygame.mixer.Sound('point.wav')


def sayeed (num):
    td=0.5

    if num < 0:
        soundObjnegative.play()
        time.sleep (td)

    x = abs(num)

    if x >= 1000000000:
        n = math.floor(x/1000000000)
       ## a=  str(n) + '.wav' 
       ## pygame.mixer.init()
       # pygame.mixer.Sound(a).play()
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
        ## a=  str(n) + '.wav' 
       ## pygame.mixer.init()
       # pygame.mixer.Sound(a).play()
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
        ## a=  str(n) + '.wav' 
       ## pygame.mixer.init()
       # pygame.mixer.Sound(a).play()
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
        a=  str(n) + '.wav' 
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
        a=  str(10*n) + '.wav' 
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
            soundObj19.play()
            time.sleep (td)

        if n == 18:
            soundObj18.play()
            time.sleep (td)

        if n == 17:
            soundObj17.play()
            time.sleep (td)

        if n == 16:
            soundObj16.play()
            time.sleep (td)
        
        if n == 15:
            soundObj15.play()
            time.sleep (td)

        if n == 14:
            soundObj14.play()
            time.sleep (td)

        if n == 13:
            soundObj13.play()
            time.sleep (td)

        if n == 12:
            soundObj12.play()
            time.sleep (td)

        if n == 11:
            soundObj11.play()
            time.sleep (td)

        if n == 10:
            soundObj10.play()
            time.sleep (td)

        if n == 9:
            soundObj9.play()
            time.sleep (td)

        if n == 8:
            soundObj8.play()
            time.sleep (td)

        if n == 7:
            soundObj7.play()
            time.sleep (td)

        if n == 6:
            soundObj6.play()
            time.sleep (td)

        if n == 5:
            soundObj5.play()
            time.sleep (td)

        if n == 4:
            soundObj4.play()
            time.sleep (td)

        if n == 3:
            soundObj3.play()
            time.sleep (td)

        if n == 2:
            soundObj2.play()
            time.sleep (td)

        if n == 1:
            soundObj1.play()
            time.sleep (td)
        

    if x > 0:
        soundObjpoint.play()
        time.sleep (td)
        n = math.floor(x/0.1)
        a=  str(n) + '.wav' 
        pygame.mixer.init()
        pygame.mixer.Sound(a).play()
        time.sleep (td)
        x = x - (n*0.1)
        
        if x > 0:
            n = math.floor(x/0.01)
            a=  str(n) + '.wav' 
            pygame.mixer.init()
            pygame.mixer.Sound(a).play()
            time.sleep (td)
            x = x - (n*0.01)

            if x > 0:
                n = math.floor(x/0.001)
                a=  str(n) + '.wav' 
                pygame.mixer.init()
                pygame.mixer.Sound(a).play()
                time.sleep (td)
                x = x - (n*0.001)
def stephen ():
    

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
    pygame.mixer.Sound(ampm + '.wav').play()
    time.sleep (2)

    pygame.mixer.init()
    pygame.mixer.Sound(d7 + '.wav').play()
    time.sleep (1)



#this says the date
    pygame.mixer.init()
    pygame.mixer.Sound(d2 + '.wav').play()
    time.sleep (1)

    sayeed (d3)
    time.sleep (1)
    sayeed (d4a)
    time.sleep (0.2)
    sayeed (d4b)
    time.sleep (0.2)
    




