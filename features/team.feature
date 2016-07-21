@team
Feature: Teams
    As a admin
    I need to be able to manage teams

    Background: I am logged in as admin
        Given I am logged in as "1"

    Scenario: List all teams
        When I go to "/admin/teams"
        Then I should see "Create new squad"

    Scenario: Create new squad
        When I go to "/admin/teams"
        And I follow "Create new squad"
        Then I should see "Save squad"