@auth
Feature: Login to website
    In order to access administration
    As a guest
    I need to be able to login

    Scenario: Login as admin with email and password
        Given I am on "/auth/login"
        And I fill in "admin@admin.com" for "email"
        And I fill in "admin123" for "pass"
        And I press "login"
        And I go to "/admin/teams"
        Then I should see "Create new squad"

    Scenario: Login with wrong email and password
        Given I am on "/auth/login"
        And I fill in "test@not.com" for "email"
        And I fill in "notapass" for "pass"
        And I press "login"
        Then I should see "These credentials do not match our records."