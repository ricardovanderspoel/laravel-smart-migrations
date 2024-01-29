<?php

$phpVersion = "8.1";
$laravelVersion = "10";

return [
    'openai_model' => 'gpt-4-0125-preview',
    //'openai_model' => 'gpt-3.5-turbo-1106',
    'enhancements' => [
        'model' => [
            'context' => "This is a file generator, aimed to return a response starting with '<?php', including necessary namespace and use statements, without any text explanation or inline comments. The generated file, intended for Laravel $laravelVersion on PHP $phpVersion, should:
            - Reflect a fully working PHP class modeling database structure and relationships based on a migration schema.
            - Ensure attributes are appropriately casted, and necessary accessors or mutators are included.
            - Omit unused methods or placeholders, contributing to a clean, immediately deployable class.
            It is crucial to use '<?php' at the start of the generated code to ensure seamless automatic incorporation.",
            'context_files' => ['migration', 'model'],
        ],
        'factory' => [
            'context' => "This request generates a factory file for Laravel $laravelVersion on PHP $phpVersion, starting with '<?php' and void of any preceding text, explanation, or inline comments. Expected contents include:
            - Namespace declaration and relevant use statements.
            - A factory definition utilizing Faker to generate realistic data, considering defined field types and model relationships.
            - Exclusion of any non-functional, placeholder, or unused methods from the output.
            The emphasis is on generating a fully working PHP file that can be immediately implemented.",
            'context_files' => ['migration', 'factory'],
        ],
        'seeder' => [
            'context' => "This file generator creates a seeder file for Laravel $laravelVersion on PHP $phpVersion, with the output starting with '<?php', omitting any introductory text, explanations, or inline comments. Requirements include:
            - Correct namespace and usage statements to support immediate functionality.
            - Utilization of factories to seed database tables with data reflective of real-world applications.
            - Avoidance of placeholder code and ensuring the absence of non-functional methods.
            The generated PHP file should be readily integrable within the application.",
            'context_files' => ['model', 'seeder', 'factory'],
        ],
        'request' => [
            'context' => "This task involves generating a request validation file for Laravel $laravelVersion on PHP $phpVersion, ensuring the file starts with '<?php' and includes no textual explanations or inline comments. The completion requires:
            - Proper namespace and use statements for instant use.
            - Defined validation rules aligning with the model's attributes to safeguard data integrity.
            - Production of a refined PHP class sans any placeholder or redundant methods.
            Aimed to yield an actionable request validation class, fulfilling Laravel's request handling conventions.",
            'context_files' => ['model', 'request'],
        ],
        'resource' => [
            'context' => "The objective is to produce a resource file for Laravel $laravelVersion on PHP $phpVersion, prefaced with '<?php' and excluding any form of text explanation or inline commentary. Essential elements encompass:
            - Necessary namespace and use declarations for proper functionality.
            - Structured transformation of model data into JSON format, tailored for client consumption.
            - Elimination of any placeholder or ineffective methods from the final code.
            The endeavor ensures the delivery of a deployable resource class, crafted to enhance data presentation in client applications.",
            'context_files' => ['model', 'resource'],
        ],
        'controller' => [
            'context' => "This command prompts the creation of a controller file for Laravel $laravelVersion on PHP $phpVersion, initiating with '<?php' and devoid of prefatory text, explanations, or inline comments. It necessitates:
            - Appropriate namespace and use statements, facilitating immediate deployment.
            - Implementation of CRUD operations congruent with RESTful design principles.
            - Refraining from including non-essential, placeholder, or empty methods.
            The process is designed to generate a controller class ready for integration, promoting seamless RESTful API creation.",
            'context_files' => ['model', 'request', 'resource', 'controller'],
        ],
        'test' => [
            'context' => "This configuration leads to the generation of a PHPUnit test file for Laravel $laravelVersion on PHP $phpVersion, beginning with '<?php' and free from any introductory text, explanations or inline comments. The configuration aims for:
            - Correct namespace inclusion and the adoption of necessary use statements.
            - Creation of comprehensive tests for each method in the controller, covering both success and failure scenarios.
            - Exclusion of unfinished, superfluous, or placeholder methods for a clean, operational test class.
            This setup guarantees the production of a PHPUnit test class, facilitating immediate and effective testing of the application functionalities.",
            'context_files' => ['model', 'request', 'resource', 'controller', 'factory', 'seeder'],
        ],
    ],
];
