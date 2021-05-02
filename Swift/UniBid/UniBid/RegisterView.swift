//
//  RegisterView.swift
//  UniBid
//
//  Created by Mario Yordanov on 9.04.21.
//

import UIKit

class RegisterView: UIViewController, UITextFieldDelegate, UIPickerViewDelegate, UIPickerViewDataSource {

    

    override func viewDidLoad() {
        super.viewDidLoad()

        // Do any additional setup after loading the view.
        emailAddress.delegate = self
        password.delegate = self
        confirmPassword.delegate = self
        forename.delegate = self
        surname.delegate = self
        address.delegate = self
        postcode.delegate = self
        pickerView.delegate = self
        pickerView.dataSource = self
        institution.inputView = pickerView
        password.isSecureTextEntry = true
        confirmPassword.isSecureTextEntry = true
        
        
        
        let tap = UITapGestureRecognizer(target: self, action: #selector(handleTap))
        view.addGestureRecognizer(tap) // Add gesture recognizer to background view
    }
    
    let univeristies = ["University of Aberdeen", "Abertay University", "Aberystwyth University", "Anglia Ruskin University", "Arden University", "Aston University", "Bangor University", "University of Bath", "Bath Spa University", "University of Bedfordshire", "University of Birmingham", "Birmingham City University", "Bishop Grosseteste University", "University of Bolton", "The Arts University Bournemouth", "Bournemouth University", "BPP University", "University of Bradford", "University of Brighton", "University of Bristol", "Brunel University", "University of Buckingham", "Buckinghamshire New University", "King's College Chapel of the University of Cambridge", "University of Cambridge", "Canterbury Christ Church University", "Cardiff Metropolitan University", "Cardiff University", "University of Chester", "University of Chichester", "Coventry University", "Cranfield University", "University for the Creative Arts", "University of Cumbria", "De Montfort University", "University of Derby", "University of Dundee", "Durham University", "University of East Anglia", "University of East London", "Edge Hill University", "University of Edinburgh", "Edinburgh Napier University", "University of Essex", "Falmouth University", "University of Glasgow", "Glasgow Caledonian University", "University of Gloucestershire", "University of Greenwich", "Harper Adams University", "Hartpury University", "Heriot-Watt University", "University of Hertfordshire", "University of the Highlands & Islands", "University of Huddersfield", "University of Hull", "Imperial College London", "Keele University", "University of Kent", "Kingston University", "University of Central Lancashire", "Lancaster University", "University of Leeds", "Leeds Arts University", "Leeds Trinity University", "University of Leicester", "University of Lincoln", "University of Liverpool", "Liverpool Hope University", "Liverpool John Moores University", "University of London", "London Metropolitan University", "London South Bank University", "Loughborough University", "University of Manchester", "Manchester Metropolitan University", "Middlesex University", "Newcastle University", "Newman University, Birmingham", "University of Northampton", "Northumbria University", "Norwich University of the Arts", "University of Nottingham", "Nottingham Trent University", "The Open University", "University of Oxford", "Oxford Brookes University", "Plymouth Marjon University ", "University of Plymouth", "University of Portsmouth", "Queen Margaret University", "Queen's University Belfast", "Ravensbourne University London", "Foxhill House", "University of Reading", "Regent's University London", "The Robert Gordon University", "Roehampton University, London", "Royal Agricultural University", "University of Salford", "University of Sheffield", "Sheffield Hallam University", "University of South Wales", "University of Southampton", "Solent University", "University of St Andrews", "St Mary's University, Twickenham", "Staffordshire University", "University of Stirling", "University of Strathclyde", "University of Suffolk", "University of Sunderland", "University of Surrey", "University of Sussex", "Swansea University", "Teesside University", "University of Ulster", "University of the Arts London", "University of Law", "University of Wales", "University of Warwick", "University of the West of England", "University of the West of Scotland", "University of West London", "University of Westminster", "University of Winchester", "University of Wolverhampton", "University of Worcester", "Wrexham Glyndwr University", "University of York", "York St John University"]
    
    var pickerView = UIPickerView()
    
    // Outlets
    @IBOutlet weak var emailAddress: UITextField!
    @IBOutlet weak var password: UITextField!
    @IBOutlet weak var confirmPassword: UITextField!
    @IBOutlet weak var forename: UITextField!
    @IBOutlet weak var surname: UITextField!
    @IBOutlet weak var address: UITextField!
    @IBOutlet weak var postcode: UITextField!
    @IBOutlet weak var institution: UITextField!
    
    // Objects
    @objc func handleTap() {
        emailAddress.resignFirstResponder() // dismiss keyboard
        password.resignFirstResponder()
        confirmPassword.resignFirstResponder()
        forename.resignFirstResponder()
        surname.resignFirstResponder()
        address.resignFirstResponder()
        postcode.resignFirstResponder()
        }
    
    // Actions
    @IBAction func registerButton(_ sender: Any) {
        let email = String(emailAddress.text!)
        let userPassword = String(password.text!)
        let userForename = String(forename.text!)
        let userSurname = String(surname.text!)
        let userPasswordDup = String(confirmPassword.text!)
        let userAddress = String(address.text!)
        let userPostcode = String(postcode.text!)
        let userUniversity = String(institution.text!)
        
        //Validations
        var alertMessageTitle = ""
        var alertMessage = ""
        var responseString = ""
        
        
        if(email == "") {
            alertMessageTitle = "Email is a mandatory field"
            alertMessage = "Please enter a valid .ac.uk email adress."
            showAlert(alertMessageTitle, alertMessage)
        }
        else if(userPassword == "") {
            alertMessageTitle = "Password is a mandatory field"
            alertMessage = "Please enter a strong password for your account."
            showAlert(alertMessageTitle, alertMessage)
        }
        else if(userPasswordDup == ""){
            alertMessageTitle = "Confrim Password is a mandatory field"
            alertMessage = "Please confirm your password."
            showAlert(alertMessageTitle, alertMessage)
        }
        else if(userForename == "") {
            alertMessageTitle = "Forename is a mandatory field"
            alertMessage = "Please enter your forename, so we can present you in the app"
            showAlert(alertMessageTitle, alertMessage)
        }
        else if(userSurname == "") {
            alertMessageTitle = "Surname is a mandatory field"
            alertMessage = "Please enter your Surname, so we can present you in the app"
            showAlert(alertMessageTitle, alertMessage)
        }
        else if(userAddress == "") {
            alertMessageTitle = "Address is a mandatory field"
            alertMessage = "Please enter your current valid address."
            showAlert(alertMessageTitle, alertMessage)
        }
        else if(userPostcode == "") {
            alertMessageTitle = "Postcode is a mandatory field"
            alertMessage = "Please enter your current valid postal code."
            showAlert(alertMessageTitle, alertMessage)
        }
        else if(userUniversity == "") {
            alertMessageTitle = "University is a mandatory field"
            alertMessage = "Please choose your current or past university / institution"
            showAlert(alertMessageTitle, alertMessage)
        }
        else if (userPassword != userPasswordDup) {
            alertMessageTitle = "Passwords does not match."
            alertMessage = "Please make sure that password fields contain the same passoword."
            showAlert(alertMessageTitle, alertMessage)
        }
        else if(email.hasSuffix("ac.uk") == false) {
            alertMessageTitle = "Not a ac.uk email address"
            alertMessage = "Please use a valid .ac.uk email address."
            showAlert(alertMessageTitle, alertMessage)
        }
        else if(userPassword.count < 8) {
            alertMessageTitle = "Password is too shot"
            alertMessage = "Please use at least 8 characters for your password."
            showAlert(alertMessageTitle, alertMessage)
        }
        
        else {
        
        let parameters = [ "forename":userForename, "surname":userSurname,
                           "email": email, "password": userPassword,
                           "password_dup": userPasswordDup,"address": userAddress,
                           "postcode": userPostcode, "university": userUniversity]
        
        let url = URL(string: "https://student.csc.liv.ac.uk/~sglbowma/api/register.php")!
                var request = URLRequest(url: url)
                request.setValue("application/x-www-form-urlencoded", forHTTPHeaderField: "Content-Type")
                request.httpMethod = "POST"
                request.httpBody = parameters.percentEncoded()

                let task = URLSession.shared.dataTask(with: request) { data, response, error in
                    guard let data = data,
                        let response = response as? HTTPURLResponse,
                        error == nil else {                                              // check for fundamental networking error
                        print("error", error ?? "Unknown error")
                        return
                    }

                    guard (200 ... 299) ~= response.statusCode else {                    // check for http errors
                        print("statusCode should be 2xx, but is (response.statusCode)")
                        print("response = \(response)")
                        return
                    }

                    responseString = String(data: data, encoding: .utf8)!
                    print("responseString = \(responseString)")
                    if(responseString == "Email in Use"){
                        //print(1)
                        alertMessageTitle = "Email in use"
                        alertMessage = "This email has already been registered."
                    } else {
                        alertMessageTitle = "Successful Registartion"
                        alertMessage = "You have successfully created your account at UniBid"
                    }
                    self.showAlert(alertMessageTitle, alertMessage)
                }
            task.resume()
        }
    }
    
    
    // UITextFieldDelegete Methods
    func textFieldShouldReturn(_ textField: UITextField) -> Bool {
        emailAddress.resignFirstResponder() // dismiss keyboard
        password.resignFirstResponder()
        confirmPassword.resignFirstResponder()
        forename.resignFirstResponder()
        surname.resignFirstResponder()
        address.resignFirstResponder()
        postcode.resignFirstResponder()
        return true
    }
    
    // UIPickerView Methods
    func numberOfComponents(in pickerView: UIPickerView) -> Int {
        return 1
    }
    
    func pickerView(_ pickerView: UIPickerView, numberOfRowsInComponent component: Int) -> Int {
        return univeristies.count
    }
    
    func pickerView(_ pickerView: UIPickerView, titleForRow row: Int, forComponent component: Int) -> String? {
        return univeristies[row]
    }
    
    func pickerView(_ pickerView: UIPickerView, didSelectRow row: Int, inComponent component: Int) {
        institution.text = univeristies[row]
        institution.resignFirstResponder()
    }
    
    
    func showAlert(_ messageTitle: String, _ message: String) {
        DispatchQueue.main.async {
            //Create an alert
            let alert = UIAlertController(title: messageTitle, message: message, preferredStyle: .alert)
            //Add actions
            if(messageTitle == "Successful Registartion"){
                let alertAction = UIAlertAction(title: "Login", style: .cancel, handler: {(action) -> Void in
                    //Call the MainViewController
                    let vc = self.storyboard?.instantiateViewController(identifier: "LogInViewController") as! LogInView
                    vc.modalPresentationStyle = .fullScreen
                    self.present(vc, animated: true, completion: nil)
                })
                
                alert.addAction(alertAction)
            } else {
                alert.addAction(UIAlertAction(title: "OK", style: .default, handler: nil))
            }

            //Present alert
            self.present(alert, animated: true, completion: nil)
        }
    }
    
    
    
    /*
    // MARK: - Navigation

    // In a storyboard-based application, you will often want to do a little preparation before navigation
    override func prepare(for segue: UIStoryboardSegue, sender: Any?) {
        // Get the new view controller using segue.destination.
        // Pass the selected object to the new view controller.
    }
    */

}
