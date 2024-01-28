<?php

return [
    'enhancements' => [
        'model' => [
            'context' => "Generate a Laravel model enhancement that accurately reflects a real-life application, including relationships between models, data type casts, and any necessary getters/setters for attribute manipulation. Your enhancement should directly correlate to the provided migration schema and current model structure. Do not create anything that is not finished as it will be implemented automatically. Ensure the generated code starts with <?php and does not include placeholder comments, text or explainations in your response. The structure of the response is very important.",
            'context_files' => ['migration', 'model'],
        ],
        'factory' => [
            'context' => "Create a Laravel factory enhancement using Faker to generate realistic and relevant data. The enhancement should consider the specific fields and data types outlined in the model, ensuring that the generated data is suitable for testing and development purposes. Do not create anything that is not finished as it will be implemented automatically. Ensure the generated code starts with <?php and does not include placeholder comments, text or explainations in your response. The structure of the response is very important.",
            'context_files' => ['migration', 'factory'],
        ],
        'seeder' => [
            'context' => "Develop a Laravel seeder enhancement with the aim of populating the database with realistic test data. This enhancement should leverage the factory definitions to create data that is relevant to the model's real-world application. Do not create anything that is not finished as it will be implemented automatically. Ensure the generated code starts with <?php and does not include placeholder comments, text or explainations in your response. The structure of the response is very important.",
            'context_files' => ['model', 'seeder', 'factory'],
        ],
        'request' => [
            'context' => "Craft a Laravel request validation enhancement that introduces validation rules and authorization logic tailored to the model's attributes and business logic. Ensure that the enhancement is comprehensive, covering all necessary validation scenarios to maintain data integrity. Do not create anything that is not finished as it will be implemented automatically. Ensure the generated code starts with <?php and does not include placeholder comments, text or explainations in your response. The structure of the response is very important.",
            'context_files' => ['model', 'request'],
        ],
        'resource' => [
            'context' => "Enhance a Laravel resource file to format outgoing JSON responses meticulously. This enhancement should consider the model's attributes and relationships, ensuring that the resource output is both accurate and optimized for consumption in client applications. Do not create anything that is not finished as it will be implemented automatically. Ensure the generated code starts with <?php and does not include placeholder comments, text or explainations in your response. The structure of the response is very important.",
            'context_files' => ['model', 'resource'],
        ],
        'controller' => [
            'context' => "Implement a set of CRUD operations within a Laravel controller file, adhering strictly to RESTful design principles. The enhancement should seamlessly integrate with the model, request, and resource enhancements to provide a cohesive and logically structured controller for managing model data. Do not create anything that is not finished as it will be implemented automatically. Ensure the generated code starts with <?php and does not include placeholder comments, text or explainations in your response. The structure of the response is very important.",
            'context_files' => ['model', 'request', 'resource', 'controller'],
        ],
    ],
];
