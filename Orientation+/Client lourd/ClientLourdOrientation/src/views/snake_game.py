#!/usr/bin/env python3
import curses
import random
import time

class SnakeGame:
    def __init__(self, screen):
        # Initialize screen
        self.screen = screen
        curses.curs_set(0)  # Hide the cursor
        screen.timeout(100)  # Input delay in milliseconds

        # Get screen dimensions
        self.height, self.width = screen.getmaxyx()
        
        # Initialize snake's initial position at the center
        self.snake = [
            [self.height // 2, self.width // 4],
            [self.height // 2, self.width // 4 - 1],
            [self.height // 2, self.width // 4 - 2]
        ]
        
        # Initialize snake's direction (right)
        self.direction = curses.KEY_RIGHT
        
        # Create initial food
        self.food = self.create_food()
        
        # Initialize score
        self.score = 0
        
        # Create a border
        self.screen.border(0)
        
        # Initialize game state
        self.game_over = False
        
    def create_food(self):
        """Create a new food at a random position"""
        while True:
            # Generate random coordinates within boundaries
            y = random.randint(1, self.height - 2)
            x = random.randint(1, self.width - 2)
            
            # Check if the position is not occupied by the snake
            if [y, x] not in self.snake:
                return [y, x]
    
    def display_score(self):
        """Display the current score"""
        score_text = f"Score: {self.score}"
        self.screen.addstr(0, self.width // 2 - len(score_text) // 2, score_text)
    
    def process_input(self):
        """Process keyboard input"""
        # Get the next key
        key = self.screen.getch()
        
        # Update direction based on key, ensuring the snake can't go in the opposite direction
        if key == curses.KEY_UP and self.direction != curses.KEY_DOWN:
            self.direction = curses.KEY_UP
        elif key == curses.KEY_DOWN and self.direction != curses.KEY_UP:
            self.direction = curses.KEY_DOWN
        elif key == curses.KEY_LEFT and self.direction != curses.KEY_RIGHT:
            self.direction = curses.KEY_LEFT
        elif key == curses.KEY_RIGHT and self.direction != curses.KEY_LEFT:
            self.direction = curses.KEY_RIGHT
        elif key == ord('q'):
            self.game_over = True
    
    def update(self):
        """Update game state"""
        # Get the current head position
        head = self.snake[0].copy()
        
        # Update head position based on direction
        if self.direction == curses.KEY_UP:
            head[0] -= 1
        elif self.direction == curses.KEY_DOWN:
            head[0] += 1
        elif self.direction == curses.KEY_LEFT:
            head[1] -= 1
        elif self.direction == curses.KEY_RIGHT:
            head[1] += 1
        
        # Insert new head at the beginning of the snake
        self.snake.insert(0, head)
        
        # Check for collision with walls
        if (head[0] <= 0 or head[0] >= self.height - 1 or 
            head[1] <= 0 or head[1] >= self.width - 1):
            self.game_over = True
            return
        
        # Check for collision with self (excluding the head)
        if head in self.snake[1:]:
            self.game_over = True
            return
        
        # Check if snake has eaten the food
        if head == self.food:
            # Create new food
            self.food = self.create_food()
            # Increase score
            self.score += 1
        else:
            # Remove tail if not eating
            self.snake.pop()
    
    def render(self):
        """Render the game state"""
        # Clear the screen
        self.screen.clear()
        
        # Draw border
        self.screen.border(0)
        
        # Draw snake
        for i, segment in enumerate(self.snake):
            char = '@' if i == 0 else '#'  # Head is @ and body is #
            try:
                self.screen.addch(segment[0], segment[1], char)
            except curses.error:
                # Handle potential curses errors when drawing at edge
                pass
        
        # Draw food
        try:
            self.screen.addch(self.food[0], self.food[1], '*')
        except curses.error:
            pass
        
        # Display score
        self.display_score()
        
        # Refresh the screen
        self.screen.refresh()
    
    def display_game_over(self):
        """Display game over message"""
        game_over_msg = "GAME OVER!"
        score_msg = f"Final Score: {self.score}"
        restart_msg = "Press 'q' to exit"
        
        # Calculate positions for centered messages
        y_center = self.height // 2
        x_center = self.width // 2
        
        # Display messages
        self.screen.clear()
        self.screen.border(0)
        self.screen.addstr(y_center - 1, x_center - len(game_over_msg) // 2, game_over_msg)
        self.screen.addstr(y_center, x_center - len(score_msg) // 2, score_msg)
        self.screen.addstr(y_center + 1, x_center - len(restart_msg) // 2, restart_msg)
        self.screen.refresh()
        
        # Wait for 'q' to exit
        while True:
            key = self.screen.getch()
            if key == ord('q'):
                break
    
    def run(self):
        """Main game loop"""
        while not self.game_over:
            self.process_input()
            self.update()
            self.render()
        
        # Display game over screen
        self.display_game_over()

def main(screen):
    # Initialize colors
    curses.start_color()
    curses.init_pair(1, curses.COLOR_GREEN, curses.COLOR_BLACK)
    curses.init_pair(2, curses.COLOR_RED, curses.COLOR_BLACK)
    
    # Create and run the game
    game = SnakeGame(screen)
    game.run()

if __name__ == "__main__":
    try:
        # Initialize curses and run the main function
        curses.wrapper(main)
    except KeyboardInterrupt:
        # Handle Ctrl+C gracefully
        pass
    finally:
        # Ensure terminal is reset properly
        curses.endwin()
        print("Snake game terminated. Thanks for playing!")

