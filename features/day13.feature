Feature:
    In order to verify the logic behind my algorithms for day 13 of AdventOfCode
    As me
    I want to check the values expected in the example against the one found by my code

    Scenario: Check part1
        When I request "/day13/1/day13test" using HTTP method "GET"
        Then the status code must be 200
        And the response should be "405"

    Scenario: Check part2
        When I request "/day13/2/day13test" using HTTP method "GET"
        Then the status code must be 200
        And the response should be "400"
