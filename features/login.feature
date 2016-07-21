Feature: Test feature

    Scenario: I login with username and password
        Given I am on "/auth/login"
        And I fill in "admin@admin.com" for "email"
        And I fill in "admin123" for "pass"
        And I press "login"
        Then I should see "Page missing or under construction"