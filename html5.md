I tweaked the Arcade Shooter.
 
My first significant change was increasing the difficulty over time. After the score is above 3, the number of enemies appearing at a time will increase as certain scores are reached.
Because it is difficult to capture the game moving in real time I have attached the code snippets for my changes:

![image](https://user-images.githubusercontent.com/33039967/124473948-ee0dfd00-dd6d-11eb-9764-95cbf9f37a32.png)

Condition statements check score and increase enemy count based on score


My second significant change was to add a rapid shooting functionality that allows the user to press 'C' in order to increase the firing rate of their ship.

![image](https://user-images.githubusercontent.com/33039967/124473599-8657b200-dd6d-11eb-9a60-47221751ebf3.png)

creates a new variable to determine whether to shoot normally or fast.

![image](https://user-images.githubusercontent.com/33039967/124474187-3e855a80-dd6e-11eb-993b-d8412813d7cd.png)

listener for 'C' button added

![image](https://user-images.githubusercontent.com/33039967/124474349-696fae80-dd6e-11eb-9b74-c1b259817d17.png)

draw() function checks if user is shooting normally or fast and adjusts the speed of shooting

During this lesson, I learned more about how javascript and html work together and I learned about the capabilities of html canvas and its ability to allow for unique graphics capabilities in only html and js. It makes more sense to me now that the capabilities of HTML5 made adobe flash more obsolete.
