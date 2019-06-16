import sys
import os
from selenium import webdriver
from credentials import *
browser = webdriver.Chrome(executable_path=r"/Users/angelogiacco/Documents/GitHub/WaterPoloLeagueWebsiteCoursework/debug/recaptcha_testing/chromedriver")
browser.get('http://emiswaterpolo.dx.am/login.html')
admin_button = browser.find_elements_by_xpath('//*[@id="login-form"]/form/div[1]/label[3]/input')[0]
admin_button.click()
email_input = browser.find_elements_by_xpath('//*[@id="login-form"]/form/input[1]')[0]
email_input.send_keys(email)
password_input = browser.find_elements_by_xpath('//*[@id="login-form"]/form/input[2]')[0]
password_input.send_keys(password)
submit_button = browser.find_elements_by_xpath('//*[@id="submit"]')[0]
submit_button.click()
