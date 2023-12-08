Feature:
    In order to verify the logic behind my algorithms for day 8 of AdventOfCode
    As me
    I want to check the values expected in the example against the one found by my code

    Scenario: Check part1
        When I request "/day8/1/day8test" using HTTP method "GET"
        Then the status code must be 200
        And the response should be "6"

    Scenario: Check part2
        When I request "/day8/2/day8-2test" using HTTP method "GET"
        Then the status code must be 200
        And the response should be "6"
