# itws2110-Section1-lifrim

Repo - https://github.com/mattLif/itws2110-Section1-lifrim

1) Explain what each of your classes and methods does, the order in which methods are invoked, and the flow of execution after one of the operation buttons has been clicked.
Each of my subclasses inherits the properties of the abstract class Operation, including the variables operand_1 and operand_2. The constructor for an object of type Operation is also inherited, as well as the abstract functions operate() and getEquation(). Each subclass defines operate() to perform the respective operation between the operands (ex. Subtraction performs "operand_1 - operand_2"). The only deviation is in Division, where an error is thrown if operand_2 is 0. getEquation() is also defined differently in each subclass to print out an arithmetic equation using the operands and operator. The order of method calls is as follows: Form submission -> POST request received, $_POST checked -> correct operation determined, corresponding object created (ex. new Addition($o1, $o2)), $op->getEquation() called, inside getEquation() -> $this->operate() called, result returned -> formatted equation string -> printed. The flow of execution after a button is pressed is as follows: Each button sends a different POST variable (add, sub, mult, div), the corresponding object is created, $op->getEquation() is called, getEquation() calls operate(), result is displayed on the page.

2) Also explain how the application would differ if you were to use $_GET, and why this may or may not be preferable.
To use $_GET instead of post, the forms method property would have to be changed to $_GET instead of $_POST, and all instances of $_POST would need to be replaced. If this was done, the data entered by the user would be visible in the website's URL, and could be manipulated through alterations to the URL. For a small calculator, this isn't an issue, but for sensitive data, this would not be ideal. There are also size limits on how long a URL can be, and therefore size limits on the data that can be enetered. This is not the case with $_POST, as $_POST sends data in the HTTP request, making it more secure and less restricted in size.


3) Finally, please explain whether or not there might be another (better +/-) way to determine which button has been pressed and take the appropriate action
One possible way to check which button has been pressed instead of using multiple if statements would be using a map. First, change the name of all the buttons to be the same (in my example I use 'operation'). Then create a map, mapping each value (Add, Subtract, Multiply, Divide) to its corresponding function (Addition, Subtraction, Multiplication, Division). Then call the appropriate class besed on which button was pressed. I wrote the code below:

$operations = [
    'Add' => 'Addition',
    'Subtract' => 'Subtraction',
    'Multiply' => 'Multiplication',
    'Divide' => 'Division'
];

if (isset($_POST['operation']) && isset($operations[$_POST['operation']])) {
    $class = $operations[$_POST['operation']];
    $op = new $class($o1, $o2);
}

Hello!
Lab 6 was designing a calculator using PHP. This lab was fairly simple, and I found the hardest part to be just installing php on my computer to be able to run the php file on my local computer. Much of what I did in this lab, polymorphism and inheritance, are topics I learned in intro to CS1 and Data Structures, so I did not have much difficulty grasping the concept of the php code. I even made a slight modification where I saw fit, which was adding an error catching feature when dividing by 0. This lab was pretty simple, and I was able to complete it relatively easily.
