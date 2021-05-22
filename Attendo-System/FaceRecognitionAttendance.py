import cv2
import numpy as np
import face_recognition
import os
from datetime import datetime
import tkinter as tk

window = tk.Tk()
window.title("Attendo")
window.configure(background='navajo white')
window.grid_rowconfigure(0, weight=1)
window.grid_columnconfigure(0, weight=1)


logo = tk.Label(
    text="Attendo",
    bg="navajo white", fg="navy", font=('times', 40, 'bold'))
logo.place(x=590,y=30)

message = tk.Label(
    text="Developors : Yash Jungade | Kartik Bodhankar | Shubham Dalvi | Raj Khetale | Nitee Dhuri | Rugved Kharbade\nMentor : Prof. Akhil Masurkar | Deptartment of Electronics Engineering VIT",
    bg="navajo white", fg="black", font=('times', 10, 'bold'))
message.place(x=375,y=650)

message1 = tk.Label(
    text="Face Recognition Based Staff Attendance System",
    bg="navajo white", fg="black", width=40,
    font=('times', 30, 'bold'))
message1.place(x=200, y=130)

message2 = tk.Label(
    window, text="Vidyalankar Institute of Technology",
    bg="navajo white", fg="navy", width=40,
    height=2, font=('times', 30, 'bold'))

message2.place(x=200, y=200)

message3 = tk.Label(
    window, text="Welcome\nHave A Good Day!",
    bg="navajo white", fg="black", width=40,
    height=2, font=('times', 30, 'bold'))

message3.place(x=200, y=350)


path = 'ImagesAttendance'
images = []
classNames = []
myList = os.listdir(path)
print(myList)
for cl in myList:
    curImg = cv2.imread(f'{path}/{cl}')
    images.append(curImg)
    classNames.append(os.path.splitext(cl)[0])
print(classNames)


def findEncodings(images):
    encodeList = []
    for img in images:
        img = cv2.cvtColor(img, cv2.COLOR_BGR2RGB)
        encode = face_recognition.face_encodings(img)[0]
        encodeList.append(encode)
        print(encodeList)
    return encodeList


def markAttendance(name):
    with open('.csv/Attendance.csv', 'r+') as f:
        myDataList = f.readlines()
        nameList = []
        for line in myDataList:
            entry = line.split(',')
            nameList.append(entry[0])
            nameList.append(entry[1])
        if name not in nameList or x not in nameList:
            now = datetime.now()
            dtString = now.strftime('%H:%M:%S')
            f.writelines(f'\n{name},{x},{dtString}')

now = datetime.now()
x = now.strftime('%d %B %Y')

encodeListKnown = findEncodings(images)
print('Encoding Complete')

def Recognize():
    cap = cv2.VideoCapture(0)
    while True:
        success, img = cap.read()
        imgS = cv2.resize(img, (0, 0), None, 0.25, 0.25)
        imgS = cv2.cvtColor(imgS, cv2.COLOR_BGR2RGB)

        facesCurFrame = face_recognition.face_locations(imgS)
        encodesCurFrame = face_recognition.face_encodings(imgS, facesCurFrame)

        for encodeFace, faceLoc in zip(encodesCurFrame, facesCurFrame):
            matches = face_recognition.compare_faces(encodeListKnown, encodeFace)
            faceDis = face_recognition.face_distance(encodeListKnown, encodeFace)
            print(faceDis)
            matchIndex = np.argmin(faceDis)

            if matches[matchIndex]:
                name = classNames[matchIndex]
                print("Welcome "+name+"\nHave A Good Day!")
                message4 = tk.Label(
                    window, text=str(name),
                    bg="navajo white", fg="black",
                    width="40",
                    font=('times', 30, 'bold'))

                message4.place(x=200, y=300)

                y1, x2, y2, x1 = faceLoc
                y1, x2, y2, x1 = y1 * 4, x2 * 4, y2 * 4, x1 * 4
                cv2.rectangle(img, (x1, y1), (x2, y2), (255, 255, 255), 2)
                cv2.putText(img, name, (x1 + 6, y2 + 30), cv2.FONT_HERSHEY_COMPLEX, 1, (128, 0, 0), 2)
                markAttendance(name)
        cv2.imshow('Face Recognition Attendance System', img)
        cv2.waitKey(1)
        c = cv2.waitKey(1)
        if c == 27 or c == 10:
            cv2.destroyAllWindows()
            cap.release()


recognizeButton = tk.Button(window, text="Recognize",
                     command=Recognize, fg="navy", bg="khaki",
                     width=20, height=3, activebackground="navy",
                     font=('times', 15, ' bold '))
recognizeButton.place(x=550, y=500)

window.mainloop()