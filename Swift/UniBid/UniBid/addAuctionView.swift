//
//  addAuctionView.swift
//  UniBid
//
//  Created by Mario Yordanov on 22.04.21.
//

import UIKit

class addAuctionView: UIViewController, UITextFieldDelegate, UITextViewDelegate, UIPickerViewDelegate, UIPickerViewDataSource {


    override func viewDidLoad() {
        super.viewDidLoad()

        // Do any additional setup after loading the view.
        listingTitle.delegate = self
        listingDescription.delegate = self
        pickerViewCategory.delegate = self
        pickerViewCategory.dataSource = self
        listingCategory.inputView = pickerViewCategory
        listingBidPrice.delegate = self
        listingBuyNowPrice.delegate = self
        pickerViewDuration.delegate = self
        pickerViewDuration.dataSource = self
        listingDuration.inputView = pickerViewDuration
        
        
        let tap = UITapGestureRecognizer(target: self, action: #selector(handleTap))
        view.addGestureRecognizer(tap) // Add gesture recognizer to background view
    }
    
    let categories = ["1A","21","312","ASD"]
    let durations = ["opt1","opt2"]
    
    var pickerViewCategory = UIPickerView()
    var pickerViewDuration = UIPickerView()
    
    //UI elements
    @IBOutlet weak var listingTitle: UITextField!
    @IBOutlet weak var listingDescription: UITextView!
    @IBOutlet weak var listingCategory: UITextField!
    @IBOutlet weak var listingBidPrice: UITextField!
    @IBOutlet weak var listingBuyNowPrice: UITextField!
    @IBOutlet weak var listingDuration: UITextField!
    @IBOutlet weak var charactersLeft: UILabel!
    
    
    // Objects
    @objc func handleTap() {
        listingTitle.resignFirstResponder() // dismiss keyboard
        listingDescription.resignFirstResponder()
        listingBidPrice.resignFirstResponder()
        listingBuyNowPrice.resignFirstResponder()
    }
    
    
    // UITextFieldDelegete Methods
    func textFieldShouldReturn(_ textField: UITextField) -> Bool {
        listingTitle.resignFirstResponder() // dismiss keyboard
        listingDescription.resignFirstResponder()
        
        listingBidPrice.resignFirstResponder()
        listingBuyNowPrice.resignFirstResponder()
        
        
        return true
    }
    
    func textField(_ textField: UITextField, shouldChangeCharactersIn range: NSRange, replacementString string: String) -> Bool {
        if textField == listingTitle { // make sure the listing title is under 150 characters
            // get the current text, or use an empty string if that failed
            let currentText = textField.text ?? ""

            // attempt to read the range they are trying to change, or exit if we can't
            guard let stringRange = Range(range, in: currentText) else { return false }

            // add their new text to the existing text
            let updatedText = currentText.replacingCharacters(in: stringRange, with: string)

            // make sure the listing title is under 150 characters
            return updatedText.count <= 150
        } else if textField == listingBidPrice || textField == listingBuyNowPrice { // make sure we have only two digits after the . for the prices
            guard let oldText = textField.text, let r = Range(range, in: oldText) else {
                    return true
                }

                let newText = oldText.replacingCharacters(in: r, with: string)
                let isNumeric = newText.isEmpty || (Double(newText) != nil)
                let numberOfDots = newText.components(separatedBy: ".").count - 1

                let numberOfDecimalDigits: Int
            if let dotIndex = newText.firstIndex(of: ".") {
                    numberOfDecimalDigits = newText.distance(from: dotIndex, to: newText.endIndex) - 1
                } else {
                    numberOfDecimalDigits = 0
                }

                return isNumeric && numberOfDots <= 1 && numberOfDecimalDigits <= 2
            
        } else {
            return true
        }
    }
    
    // UIPickerView Methods
    func numberOfComponents(in pickerView: UIPickerView) -> Int {
        return 1
    }
    
    func pickerView(_ pickerView: UIPickerView, numberOfRowsInComponent component: Int) -> Int {
        if pickerView == pickerViewCategory {
            print(1)
            return categories.count
        } else {
            print(3)
            return durations.count
        }
    }
    
    func pickerView(_ pickerView: UIPickerView, titleForRow row: Int, forComponent component: Int) -> String? {
        if pickerView == pickerViewCategory {
            return categories[row]
        } else {
            return durations[row]
        }
    }
    
    func pickerView(_ pickerView: UIPickerView, didSelectRow row: Int, inComponent component: Int) {
        if pickerView == pickerViewCategory {
            listingCategory.text = categories[row]
            listingCategory.resignFirstResponder()
        } else {
            listingDuration.text = durations[row]
            listingDuration.resignFirstResponder()
        }
    }

    // UITextView Methods
    func textView(_ textView: UITextView, shouldChangeTextIn range: NSRange, replacementText text: String) -> Bool {
        if textView == listingDescription {
            // get the current text, or use an empty string if that failed
            let currentText = textView.text ?? ""

            // attempt to read the range they are trying to change, or exit if we can't
            guard let stringRange = Range(range, in: currentText) else { return false }

            // add their new text to the existing text
            let updatedText = currentText.replacingCharacters(in: stringRange, with: text)

            // make sure the description of a listing is under 1000 characters
            return updatedText.count <= 1000
        } else {
            return true
        }
    }
    
    func textViewDidChange(_ textView: UITextView) {
        charactersLeft.text = "\(textView.text.count)/1000"
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
